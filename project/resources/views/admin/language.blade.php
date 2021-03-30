@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Language Settings</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Language Settings</li>
                </ul>
            </div>
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div id="response"></div>
                    <form method="POST" action="{!! action('SettingsController@language',$subdomain_name) !!}" class="form-horizontal form-label-left" id="language_form">
                        {{csrf_field()}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Home<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="home" value="{{$languages[0]->home}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">About Us<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="about_us" value="{{$languages[0]->about_us}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Us<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="contact_us" value="{{$languages[0]->contact_us}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">FAQ<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="faq" value="{{$languages[0]->faq}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Search<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="search" value="{{$languages[0]->search}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="vendor" value="{{$languages[0]->vendor}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sign In<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="sign_in" value="{{$languages[0]->sign_in}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">My Account<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="my_account" value="{{$languages[0]->my_account}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">My Cart<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="my_cart" value="{{$languages[0]->my_cart}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">View Cart<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="view_cart" value="{{$languages[0]->view_cart}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Checkout<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="checkout" value="{{$languages[0]->checkout}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Continue Shopping<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="continue_shopping" value="{{$languages[0]->continue_shopping}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Proceed To Checkout<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="proceed_to_checkout" value="{{$languages[0]->proceed_to_checkout}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Empty Cart<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="empty_cart" value="{{$languages[0]->empty_cart}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Blog<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="blog" value="{{$languages[0]->blog}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Latest Blog<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="latest_blogs" class="form-control col-md-7 col-xs-12" name="latest_blogs" value="{{$languages[0]->latest_blogs}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Popular Tags<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="popular_tags" class="form-control col-md-7 col-xs-12" name="popular_tags" value="{{$languages[0]->popular_tags}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ship to a Different Address<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="ship_to_another" value="{{$languages[0]->ship_to_another}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pickup From The Location you selected<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="pickup_details" value="{{$languages[0]->pickup_details}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Top Category<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="top_category" value="{{$languages[0]->top_category}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Featured Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="featured_products" value="{{$languages[0]->featured_products}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Latest Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="latest_products" value="{{$languages[0]->latest_products}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Popular Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="popular_products" value="{{$languages[0]->popular_products}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="product_name" value="{{$languages[0]->product_name}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit Price<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="unit_price" value="{{$languages[0]->unit_price}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">SubTotal<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="subtotal" value="{{$languages[0]->subtotal}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="total" value="{{$languages[0]->total}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="quantity" value="{{$languages[0]->quantity}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Add To Cart<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="add_to_cart" value="{{$languages[0]->add_to_cart}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Out of Stock<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="out_of_stock" value="{{$languages[0]->out_of_stock}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Available<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="available" value="{{$languages[0]->available}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Reviews<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="reviews" value="{{$languages[0]->reviews}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Related Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="related_products" value="{{$languages[0]->related_products}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Return Policy<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="return_policy" value="{{$languages[0]->return_policy}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Review<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="no_review" value="{{$languages[0]->no_review}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Write A Review<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="write_a_review" value="{{$languages[0]->write_a_review}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Subscription<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="subscription" value="{{$languages[0]->subscription}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Subscribe<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="subscribe" value="{{$languages[0]->subscribe}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="address" value="{{$languages[0]->address}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Added To Cart<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="added_to_cart" value="{{$languages[0]->added_to_cart}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="description" value="{{$languages[0]->description}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Share in Social<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="share_in_social" value="{{$languages[0]->share_in_social}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Search Result<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="search_result" value="{{$languages[0]->search_result}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Products Found<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="no_result" value="{{$languages[0]->no_result}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Us Greetings<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="contact_us_today" value="{{$languages[0]->contact_us_today}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Filter Option<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="filter_option" value="{{$languages[0]->filter_option}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">All Categories<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="all_categories" value="{{$languages[0]->all_categories}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Load More<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="load_more" value="{{$languages[0]->load_more}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort By Latest Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="sort_by_latest" value="{{$languages[0]->sort_by_latest}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort By Oldest Products<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="sort_by_oldest" value="{{$languages[0]->sort_by_oldest}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort By Highest Price<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="sort_by_highest" value="{{$languages[0]->sort_by_highest}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort By Lowest Price<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="sort_by_lowest" value="{{$languages[0]->sort_by_lowest}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Street Address<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="street_address" value="{{$languages[0]->street_address}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="phone" value="{{$languages[0]->phone}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="email" value="{{$languages[0]->email}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="fax" value="{{$languages[0]->fax}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$languages[0]->name}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Review Details<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="review_details" value="{{$languages[0]->review_details}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Order Details<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="order_details" value="{{$languages[0]->order_details}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter Shipping Details<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="enter_shipping" value="{{$languages[0]->enter_shipping}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping Cost<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="shipping_cost" value="{{$languages[0]->shipping_cost}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tax<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="tax" value="{{$languages[0]->tax}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Order Now<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="order_now" value="{{$languages[0]->order_now}}" placeholder="Your Language" minlength="3" maxlength="50"type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">View Details<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="view_details" value="{{$languages[0]->view_details}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quick Review<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="quick_review" value="{{$languages[0]->quick_review}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Submit<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="submit" value="{{$languages[0]->submit}}" placeholder="Your Language" minlength="3" maxlength="50" type="text">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Website Language</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop


@section('footer')

<script type="text/javascript">

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#language_form').validate({
            rules:{
                home:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                about_us:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                contact_us:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                faq:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                search:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                vendor:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                sign_in:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                my_account:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                my_cart:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                view_cart:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                checkout:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                continue_shopping:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                proceed_to_checkout:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                empty_cart:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                blog:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                latest_blogs:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                popular_tags:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                ship_to_another:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                pickup_details:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                top_category:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                featured_products:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                latest_products:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                popular_products:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                product_name:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                unit_price:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                subtotal:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                total:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                quantity:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                add_to_cart:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                out_of_stock:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                available:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                reviews:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                related_products:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                return_policy:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                no_review:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                write_a_review:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                subscription:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                subscribe:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                address:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                added_to_cart:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                description:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                share_in_social:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                search_result:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                no_result:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                contact_us_today:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                filter_option:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                all_categories:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                load_more:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                sort_by_latest:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                sort_by_oldest:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                sort_by_highest:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                sort_by_lowest:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                street_address:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                phone:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                email:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                fax:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                name:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                review_details:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                order_details:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                enter_shipping:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                shipping_cost:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                tax:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                order_now:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                view_details:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                quick_review:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
                submit:{
                    required:true,
                    minlength:3,
                    maxlength:50
                },
            },
            highlight: function (element) {
                $(element).parent().addClass('has-error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error')
            },
            errorElement: 'span',
            errorClass: 'text-danger',
        });

    });
</script>


@stop