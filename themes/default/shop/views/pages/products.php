<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="page-contents">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div id="sticky-con">
                            <div class="margin-top-md">
                                <h4 class="title text-bold"><span><?= lang('filters'); ?></span></h4>
                                <ul class="list-group">
                                    <?php
                                    if (isset($filters['category']) && !empty($filters['category'])) {
                                        ?>
                                        <li class="list-group-item">
                                            <span class="close reset_filters_category">&times;</span>
                                            <?= $filters['category']->name; ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($filters['brand']) && !empty($filters['brand'])) {
                                        ?>
                                        <li class="list-group-item">
                                            <span class="close reset_filters_brand">&times;</span>
                                            <?= $filters['brand']->name; ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="margin-bottom-xl">
                                <h5 class="title text-bold"><span><?= lang('availability'); ?></span></h5>
                                <div class="checkbox"><label><input type="checkbox" id="in-stock"><span> <?= lang('in_stock'); ?></span></label></div>
                            </div>
                            <div class="margin-bottom-xl">
                                <h5 class="title text-bold"><span><?= lang('price_range'); ?></span></h5>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" name="min-price" id="min-price" value="" placeholder="Min" class="form-control"></input>
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" name="max-price" id="max-price" value="" placeholder="Max" class="form-control"></input>
                                    </div>
                                </div>
                            </div>

                            <?php /*
                            <div class="margin-bottom-xl">
                            <div class="title"><span>Brand & Categories</span></div>
                            <?php
                            $fbs[''] = lang('brands');
                            foreach($brands as $fb) {
                                $fbs[$fb->id] = $fb->name;
                            }
                            ?>
                            <?= form_dropdown('brands', $fbs, set_value('brands'), 'class="form-control selectpicker" style="width:100%;"'); ?>
                            <div class="margin-top-md">
                                <?php
                                $fcs[''] = lang('categories');
                                foreach($categories as $fc) {
                                    $fcs[$fc->id] = $fc->name;
                                    if ($fc->subcategories) {
                                        foreach($fc->subcategories as $fsc) {
                                            $fcs[$fsc->id] = $fsc->name;
                                        }
                                    }
                                }
                                ?>
                                <?= form_dropdown('categories', $fcs, set_value('categories'), 'class="form-control selectpicker" style="width:100%;"'); ?>
                            </div>
                        </div>
                        */ ?>

                        <?php
                        if ($side_featured) {
                            ?>
                            <h4 class="margin-top-md title text-bold">
                                <span><?= lang('featured'); ?></span>
                                <div class="pull-right">
                                    <div class="controls pull-right hidden-xs">
                                        <a class="left fa fa-chevron-left btn btn-xs btn-default" href="#carousel-example"
                                        data-slide="prev"></a>
                                        <a class="right fa fa-chevron-right btn btn-xs btn-default" href="#carousel-example"
                                        data-slide="next"></a>
                                    </div>
                                </div>
                            </h4>

                            <div id="carousel-example" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <?php
                                    $r = 0;
                                    foreach ($side_featured as $fp) {
                                        ?>
                                        <div class="item <?= empty($r) ? 'active' : ''; ?>">
                                            <div class="featured-products">
                                                <div class="product" style="z-index: 1;">
                                                    <div class="details" style="transition: all 100ms ease-out 0s;">
                                                        <?php
                                                        if ($fp->promotion) {
                                                            ?>
                                                            <span class="badge badge-right theme"><?= lang('promo'); ?></span>
                                                            <?php
                                                        }
                                                        ?>
                                                        <img src="<?= base_url('assets/uploads/'.$fp->image); ?>" alt="">
                                                        <div class="image_overlay"></div>
                                                        <div class="btn btn-sm add-to-cart" data-id="<?= $fp->id; ?>"><i class="fa fa-shopping-cart"></i> <?= lang('add_to_cart'); ?></div>
                                                        <div class="stats-container">
                                                            <span class="product_price">
                                                                <?php
                                                                if ($fp->promotion) {
                                                                    echo '<del class="text-red">'.$this->sma->convertMoney($fp->price).'</del><br>';
                                                                    echo $this->sma->convertMoney($fp->promo_price);
                                                                } else {
                                                                    echo $this->sma->convertMoney($fp->price);
                                                                }
                                                                ?>
                                                            </span>
                                                            <span class="product_name">
                                                                <a href="<?= shop_url('product/'.$fp->slug); ?>"><?= $fp->name; ?></a>
                                                            </span>
                                                            <a href="<?= shop_url('category/'.$fp->category_slug); ?>" class="link"><?= $fp->category_name; ?></a>
                                                            <?php
                                                            if ($fp->brand_name) {
                                                                ?>
                                                                <span class="link">-</span>
                                                                <a href="<?= shop_url('brand/'.$fp->brand_slug); ?>" class="link"><?= $fp->brand_name; ?></a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        </div>
                    </div>

                    <div class="col-sm-9 col-md-10">
                        <div id="loading">
                            <div class="wave">
                                <div class="rect rect1"></div>
                                <div class="rect rect2"></div>
                                <div class="rect rect3"></div>
                                <div class="rect rect4"></div>
                                <div class="rect rect5"></div>
                            </div>
                        </div>
                        <div id="grid-selector">
                            <div id="grid-menu" class="hidden-xs hidden-sm">
                                View:
                                <ul>
                                    <li class="two-col active"><i class="fa fa-th-large"></i></li>
                                    <li class="three-col"><i class="fa fa-th"></i></li>
                                </ul>
                            </div>
                            <div id="grid-sort">
                                Sort:
                                <ul>
                                    <li id="name-asc" class="sorting active"><i class="fa fa-sort-alpha-asc"></i></li>
                                    <li id="name-desc" class="sorting"><i class="fa fa-sort-alpha-desc"></i></li>
                                    <li id="price-asc" class="sorting"><i class="fa fa-sort-numeric-asc"></i></li>
                                    <li id="price-desc" class="sorting"><i class="fa fa-sort-numeric-desc"></i></li>
                                </ul>
                            </div>
                            <span class="page-info"></span>
                        </div>
                        <div class="clearfix"></div>

                        <div id="results"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <span class="page-info line-height-xl hidden-xs hidden-sm"></span>
                            </div>
                            <div class="col-md-6">
                                <div id="pagination" class="pagination-right"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
