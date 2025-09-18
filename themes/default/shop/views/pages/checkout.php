<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="page-contents">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-sm-8">
                        <div class="panel panel-default margin-top-lg">
                            <div class="panel-heading text-bold">
                                <i class="fa fa-shopping-cart margin-right-sm"></i> <?= lang('checkout'); ?>
                                <a href="<?= site_url('cart'); ?>" class="pull-right">
                                    <i class="fa fa-share"></i>
                                    <?= lang('back_to_cart'); ?>
                                </a>
                            </div>
                            <div class="panel-body">

                                <div>

                                    <!-- <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#user" aria-controls="user" role="tab" data-toggle="tab"><?= lang('returning_user'); ?></a></li>
                                        <li role="presentation"><a href="#guest" aria-controls="guest" role="tab" data-toggle="tab"><?= lang('guest_checkout'); ?></a></li>
                                    </ul>

                                    <div class="tab-content padding-lg">
                                        <div role="tabpanel" class="tab-pane fade in active" id="user"> -->
                                            <?php
                                            if ($this->loggedIn) {
                                                if (!empty($addresses)) {
                                                    echo shop_form_open('order', 'class="validate"');
                                                    echo '<div class="row">';
                                                    echo '<div class="col-sm-12 text-bold">'.lang('select_address').'</div>';
                                                    $r = 1;
                                                    foreach ($addresses as $address) {
                                                        ?>
                                                        <div class="col-sm-6">
                                                            <div class="checkbox bg">
                                                                <label>
                                                                    <input type="radio" name="address" value="<?= $address->id; ?>" <?= $r == 1 ? 'checked' : ''; ?>>
                                                                    <span>
                                                                        <?= $address->line1; ?><br>
                                                                        <?= $address->line2; ?><br>
                                                                        <?= $address->city; ?> <?= $address->state; ?><br>
                                                                        <?= $address->postal_code; ?> <?= $address->country; ?><br>
                                                                        <?= lang('phone').': '.$address->phone; ?>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $r++;
                                                    }
                                                    echo '</div>';
                                                }
                                                if (count($addresses) < 6 && !$this->Staff) {
                                                    echo '<div class="row margin-bottom-lg">';
                                                    echo '<div class="col-sm-12"><a href="#" id="add-address" class="btn btn-primary btn-sm">'.lang('add_new_address').'</a></div>';
                                                    echo '</div>';
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <?= lang('comment_any', 'comment'); ?>
                                                    <?= form_textarea('comment', set_value('comment'), 'class="form-control tip" id="comment" style="height:100px;"'); ?>
                                                </div>
                                                <?php
                                                if (!empty($addresses) && !$this->Staff) {
                                                    echo form_submit('add_order', lang('submit_order'), 'class="btn btn-theme"');
                                                }
                                                echo form_close();
                                            } else {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="well margin-bottom-no">
                                                            <?php  include FCPATH.'themes'.DIRECTORY_SEPARATOR.$Settings->theme.DIRECTORY_SEPARATOR.'shop'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.'login_form.php';  ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4 class="title"><span><?= lang('register_new_account'); ?></span></h4>
                                                        <p>
                                                            <?= lang('register_account_info'); ?>
                                                        </p>
                                                        <a href="<?= site_url('login#register'); ?>" class="btn btn-theme pull-right"><?= lang('register'); ?></a>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        <!-- </div>
                                        <div role="tabpanel" class="tab-pane fade" id="guest">
                                            Guest checkout
                                        </div>
                                    </div> -->

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div id="sticky-con" class="margin-top-lg">
                            <div class="panel panel-default">
                                <div class="panel-heading text-bold">
                                    <i class="fa fa-shopping-cart margin-right-sm"></i> <?= lang('totals'); ?>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $total = $this->sma->convertMoney($this->cart->total(), FALSE, FALSE);
                                    $shipping = $this->sma->convertMoney($this->cart->shipping(), FALSE, FALSE);
                                    $order_tax = $this->sma->convertMoney($this->cart->order_tax(), FALSE, FALSE);
                                    ?>
                                    <table class="table table-striped table-borderless cart-totals margin-bottom-no">
                                        <tr>
                                            <td><?= lang('total_w_o_tax'); ?></td>
                                            <td class="text-right"><?= $this->sma->convertMoney($this->cart->total()-$this->cart->total_item_tax()); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('product_tax'); ?></td>
                                            <td class="text-right"><?= $this->sma->convertMoney($this->cart->total_item_tax()); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('total'); ?></td>
                                            <td class="text-right"><?= $this->sma->formatMoney($total, $selected_currency->symbol); ?></td>
                                        </tr>
                                        <?php if ($Settings->tax2 !== false) {
                                            echo '<tr><td>'.lang('order_tax').'</td><td class="text-right">'.$this->sma->formatMoney($order_tax, $selected_currency->symbol).'</td></tr>';
                                        } ?>
                                        <tr>
                                            <td><?= lang('shipping'); ?> *</td>
                                            <td class="text-right"><?= $this->sma->formatMoney($shipping, $selected_currency->symbol); ?></td>
                                        </tr>
                                        <tr><td colspan="2"></td></tr>
                                        <tr class="active text-bold">
                                            <td><?= lang('grand_total'); ?></td>
                                            <td class="text-right"><?= $this->sma->formatMoney(($this->sma->formatDecimal($total)+$this->sma->formatDecimal($order_tax)+$this->sma->formatDecimal($shipping)), $selected_currency->symbol); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <code class="text-muted">* <?= lang('shipping_rate_info'); ?></code>
            </div>
        </div>
    </div>
</section>
