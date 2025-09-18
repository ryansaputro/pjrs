<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_ajax extends MY_Shop_Controller
{

    function __construct() {
        parent::__construct();
        if ($this->Settings->mmode) { redirect('notify/offline'); }
    }

    function index() {
        $this->session->set_userdata('requested_page', $this->uri->uri_string());
        if ($this->cart->total_items() < 1) {
            $this->session->set_flashdata('reminder', lang('cart_is_empty'));
            shop_redirect('products');
        }
        $this->data['page_title'] = lang('shopping_cart');
        $this->page_construct('pages/cart', $this->data);
    }

    function checkout() {
        $this->session->set_userdata('requested_page', $this->uri->uri_string());
        if ($this->cart->total_items() < 1) {
            $this->session->set_flashdata('reminder', lang('cart_is_empty'));
            shop_redirect('products');
        }
        $this->data['addresses'] = $this->loggedIn ? $this->shop_model->getAddresses() : FALSE;
        $this->data['page_title'] = lang('checkout');
        $this->page_construct('pages/checkout', $this->data);
    }

    function add($product_id) {
        if ($this->input->is_ajax_request() || $this->input->post('quantity')) {
            $product = $this->site->getProductByID($product_id);
            $options = $this->shop_model->getProductVariants($product_id);
            $price = $product->promotion ? $product->promo_price : $product->price;
            $option = FALSE;
            if (!empty($options)) {
                if ($this->input->post('option') && !empty($options)) {
                    foreach ($options as $op) {
                        if ($op['id'] == $this->input->post('option')) {
                            $option = $op;
                        }
                    }
                } else {
                    $option = array_values($options)[0];
                }
                $price = $option['price']+$price;
            }
            $selected = $option ? $option['id'] : FALSE;
            $tax_rate = $this->site->getTaxRateByID($product->tax_rate);
            $ctax = $this->site->calculateTax($product, $tax_rate, $price);
            $tax = $this->sma->formatDecimal($ctax['amount']);
            $price = $this->sma->formatDecimal($price);
            $unit_price = $this->sma->formatDecimal($product->tax_method ? $price+$tax : $price);
            $id = $this->Settings->item_addition ? md5($product->id) : md5(microtime());

            $data = array(
                'id'            => $id,
                'product_id'    => $product->id,
                'qty'           => $this->input->post('quantity') ? $this->input->post('quantity') : 1,
                'name'          => $product->name,
                'code'          => $product->code,
                'price'         => $unit_price,
                'tax'           => $tax,
                'image'         => $product->image,
                'option'        => $selected,
                'options'       => !empty($options) ? $options : NULL
            );
            if ($this->cart->insert($data)) {
                if ($this->input->post('quantity')) {
                    $this->session->set_flashdata('message', lang('item_added_to_cart'));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->cart->cart_data();
                }
            }
        }
    }

    function update($data = NULL) {
        if (is_array($data)) {
            return $this->cart->update($data);
        }
        if ($this->input->is_ajax_request()) {
            if ($rowid = $this->input->post('rowid', TRUE)) {
                $item = $this->cart->get_item($rowid);
                $product = $this->site->getProductByID($item['product_id']);
                $options = $this->shop_model->getProductVariants($product->id);
                // $option = $options ? array_values($options)[0] : FALSE;
                $price = $product->promotion ? $product->promo_price : $product->price;
                // $price = $options ? ($option['price']+$price) : $price;
                // $selected = $option ? $option['id'] : FALSE;

                if ($option = $this->input->post('option')) {
                    foreach($options as $op) {
                        if ($op['id'] == $option) {
                            $price = $price + $op['price'];
                        }
                    }
                }

                $tax_rate = $this->site->getTaxRateByID($product->tax_rate);
                $ctax = $this->site->calculateTax($product, $tax_rate, $price);
                $tax = $this->sma->formatDecimal($ctax['amount']);
                $price = $this->sma->formatDecimal($price);
                $unit_price = $this->sma->formatDecimal($product->tax_method ? $price+$tax : $price);
                // $id = $this->Settings->item_addition ? md5($product->id) : md5(microtime());

                // $options = $this->cart->product_options($rowid);
                // $price = $item['base_price'];
                
                $data = array(
                    'rowid' => $rowid,
                    'price' => $price,
                    'tax' => $tax,
                    'qty' => $this->input->post('qty', TRUE),
                    'option' => $this->input->post('option') ? $this->input->post('option', TRUE) : FALSE,
                    // 'options' => $this->cart->product_options($rowid)
                );
                if ($this->cart->update($data)) {
                    $this->sma->send_json(array('cart' => $this->cart->cart_data(true), 'status' => lang('success'), 'message' => lang('cart_updated')));
                }
            }
        }
    }

    function remove($rowid = NULL) {
        if ($rowid) {
            return $this->cart->remove($rowid);
        }
        if ($this->input->is_ajax_request()) {
            if ($rowid = $this->input->post('rowid', TRUE)) {
                if ($this->cart->remove($rowid)) {
                    $this->sma->send_json(array('cart' => $this->cart->cart_data(true), 'status' => lang('success'), 'message' => lang('cart_item_deleted')));
                }
            }
        }
    }

    function destroy() {
        if ($this->input->is_ajax_request()) {
            if ($this->cart->destroy()) {
                $this->session->set_flashdata('message', lang('cart_items_deleted'));
                $this->sma->send_json(array('redirect' => base_url()));
            } else {
                $this->sma->send_json(array('status' => lang('error'), 'message' => lang('error_occured')));
            }
        }
    }

    function add_wishlist($product_id) {
        $this->session->set_userdata('requested_page', $_SERVER['HTTP_REFERER']);
        if (!$this->loggedIn) { $this->sma->send_json(array('redirect' => site_url('login'))); }
        if ($this->shop_model->getWishlist(TRUE) >= 10) {
            $this->sma->send_json(array('status' => lang('warning'), 'message' => lang('max_wishlist'), 'level' => 'warning'));
        }
        if ($this->shop_model->addWishlist($product_id)) {
            $total = $this->shop_model->getWishlist(TRUE);
            $this->sma->send_json(array('status' => lang('success'), 'message' => lang('added_wishlist'), 'total' => $total));
        } else {
            $this->sma->send_json(array('status' => lang('info'), 'message' => lang('product_exists_in_wishlist'), 'level' => 'info'));
        }
    }

    function remove_wishlist($product_id) {
        $this->session->set_userdata('requested_page', $_SERVER['HTTP_REFERER']);
        if (!$this->loggedIn) { $this->sma->send_json(array('redirect' => site_url('login'))); }
        if ($this->shop_model->removeWishlist($product_id)) {
            $total = $this->shop_model->getWishlist(TRUE);
            $this->sma->send_json(array('status' => lang('success'), 'message' => lang('removed_wishlist'), 'total' => $total));
        } else {
            $this->sma->send_json(array('status' => lang('error'), 'message' => lang('error_occured'), 'level' => 'error'));
        }
    }

}
