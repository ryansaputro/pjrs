<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="page-contents">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="col-sm-9 col-md-10">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab"><?= lang('login'); ?></a></li>
                            <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab"><?= lang('register'); ?></a></li>
                        </ul>

                        <div class="tab-content padding-lg white bordered-light" style="margin-top:-1px;">
                            <div role="tabpanel" class="tab-pane fade in active" id="login">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="well margin-bottom-no">
                                            <?php include('login_form.php'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4 class="title"><span><?= lang('register_new_account'); ?></span></h4>
                                        <p>
                                            <?= lang('register_account_info'); ?>
                                        </p>
                                        <a href="register" class="show-tab btn btn-primary pull-right"><?= lang('register'); ?></a>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="register">

                                <?php $attrib = array('class' => 'validate', 'role' => 'form');
                                echo form_open("register", $attrib); ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('first_name', 'first_name'); ?>
                                            <div class="controls">
                                                <?= form_input('first_name', '', 'class="form-control" id="first_name" required="required" pattern=".{3,10}"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('last_name', 'last_name'); ?>
                                            <div class="controls">
                                                <?= form_input('last_name', '', 'class="form-control" id="last_name" required="required"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('company', 'company'); ?>
                                            <?= form_input('company', set_value('company'), 'class="form-control tip" id="company"'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('phone', 'phone'); ?>
                                            <div class="controls">
                                                <?= form_input('phone', '', 'class="form-control" id="phone"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('email', 'email'); ?>
                                            <div class="controls">
                                                <input type="email" id="email" name="email" class="form-control" required="required"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('username', 'username'); ?>
                                            <?= form_input('username', set_value('username'), 'class="form-control tip" id="username" required="required"'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('password', 'password'); ?>
                                            <div class="controls">
                                                <?= form_password('password', '', 'class="form-control tip" id="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"'); ?>
                                                <span class="help-block"><?= lang('pasword_hint'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?= lang('confirm_password', 'password_confirm'); ?>
                                            <div class="controls">
                                                <?= form_password('password_confirm', '', 'class="form-control" id="password_confirm" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-bv-identical="true" data-bv-identical-field="password" data-bv-identical-message="' . lang('pw_not_same') . '"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?= form_submit('register', lang('register'), 'class="btn btn-primary"'); ?>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-2">
                        <div id="sticky-con">
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
                </div>
            </div>
        </div>
    </div>
</section>
