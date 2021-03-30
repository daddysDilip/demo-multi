@extends('admin.includes.master-admin')

@section('content')

<style type="text/css">
    textarea
    {
        resize: none;
    }
    label p.small-label
    {
        text-align: right;
    }
</style>

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.GeneralSettings')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.GeneralSettings')}}</li>
                </ul>
            </div>

                <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="res">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.start -->
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#logo" data-toggle="tab" aria-expanded="true">{{trans('app.Logo')}}</a></li>
                            <li class=""><a href="#favicon" data-toggle="tab" aria-expanded="true">{{trans('app.Favicon')}}</a></li>
                            <li class=""><a href="#website" data-toggle="tab" aria-expanded="false">{{trans('app.WebsiteContents')}}</a></li>
                            <li class=""><a href="#payment" data-toggle="tab" aria-expanded="false">{{trans('app.PaymentSettings')}}</a></li>
                            <li class=""><a href="#pickup" data-toggle="tab" aria-expanded="false">{{trans('app.PickUpLocations')}}</a></li>
                            <li class=""><a href="#background" data-toggle="tab" aria-expanded="false">{{trans('app.Background')}}</a></li>
                            <li class=""><a href="#about" data-toggle="tab" aria-expanded="false">{{trans('app.AboutUs')}}</a></li>
                            <li class=""><a href="#address" data-toggle="tab" aria-expanded="false">{{trans('app.OfficeAddress')}}</a></li>
                            <li class=""><a href="#footer" data-toggle="tab" aria-expanded="false">{{trans('app.Footer')}}</a></li>
                            <li class=""><a href="#langsettings" data-toggle="tab" aria-expanded="false">{{trans('app.LanguageSettings')}}</a></li>
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="logo">
                                <br><br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="settings/logo" class="form-horizontal form-label-left" enctype="multipart/form-data" id="logo_form">
                                    {{csrf_field()}}
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CurrentLogo')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($setting[0]->logo != '')
                                            <img class="col-md-6" src="../assets/images/company/{{$setting[0]->logo}}" style="width: 30%;">
                                            @else
                                            <img class="logo" src="{!! url('assets/images/company') !!}/logo.png" alt="LOGO">
                                            @endif
                                        </div>
                                    </div><br>
                                    <!-- <input type="hidden" name="id" value="1"> -->
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ChangeLogo')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="logo" accept="image/*" />
                                        </div>

                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="favicon">
                                <br><br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="settings/favicon" class="form-horizontal form-label-left" enctype="multipart/form-data" id="website_favicon">
                                    {{csrf_field()}}
                                    @if($setting[0]->favicon != '')
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CurrentFavicon')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img class="col-md-3" src="../assets/images/{{$setting[0]->favicon}}">
                                        </div>
                                    </div><br>
                                    @endif
                                    <!-- <input type="hidden" name="id" value="1"> -->
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ChangeFavicon')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="favicon" accept="image/*" required/>
                                        </div>

                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="website">
                                <br><br>

                                <div class="ln_solid"></div>

                                <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12">
                                    <li class="active"><a href="#default_lang" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                    @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                    @foreach($current_language as $alllang)
                                        @if($alllang != get_defaultlanguage())
                                            <li class="store_lang"><a href="#{{$alllang}}" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>

                                <form method="POST" action="settings/title" class="form-horizontal form-label-left website_form" id="website_form">
                                    {{csrf_field()}}
                                    {{--<input type="hidden" name="_method" value="PUT">--}}
                                    <div class="col-md-10 col-sm-9 col-xs-12">

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="default_lang">
                                                <input type="hidden" name="id" value="{{$setting[0]->id}}">
                                                <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                @php 
                                                    $title = ''; 
                                                    $popular_tags = ''; 
                                                    $currency_sign = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $title = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->title; 

                                                        $popular_tags = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->popular_tags; 

                                                        $currency_sign = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->currency_sign; 
                                                    @endphp
                                                @endif

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{trans('app.WebsiteTitle')}} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12 title_input" data-validate-length-range="6" name="title" type="text" value="{{$title}}" minlength="3" maxlength="50">
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{trans('app.PopularTags')}} <span class="required">*</span><p class="small-label" style="text-align: right;">{{trans('app.SeparatedByComma')}}(,)</p><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea class="form-control col-md-7 col-xs-12 title_input" name="popular_tags" required="required">{{$popular_tags}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{trans('app.CurrencySign')}} <span class="required">*</span><p class="small-label" style="text-align: right;">{{trans('app.e.g.')}} $ , &euro;</p><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12 title_input" name="currency_sign" required="required" value="{{$currency_sign}}"/>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach($current_language as $alllang)
                                                @if($alllang != get_defaultlanguage())
                                                @php 
                                                    $title = ''; 
                                                    $popular_tags = ''; 
                                                    $currency_sign = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $title = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->title; 

                                                        $popular_tags = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->popular_tags; 

                                                        $currency_sign = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->currency_sign; 
                                                    @endphp
                                                @endif
                                                <div class="tab-pane" id="{{$alllang}}">
                                                    <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{trans('app.WebsiteTitle')}} <p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12 title_input" data-validate-length-range="6" name="trans_title[]" type="text" value="{{$title}}" minlength="3" maxlength="50">
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12 title_input" for="title"> {{trans('app.PopularTags')}} <p class="small-label" style="text-align: right;">{{trans('app.SeparatedByComma')}}(,)</p><p class="small-label">({{get_language_name($alllang)}})</p></label>


                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control col-md-7 col-xs-12 title_input" name="trans_popular_tags[]">{{$popular_tags}}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{trans('app.CurrencySign')}} <p class="small-label" style="text-align: right;">{{trans('app.e.g.')}} $ , &euro;</p><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="trans_currency_sign[]" value="{{$currency_sign}}"/>
                                                        </div>
                                                    </div>

                                                </div>
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h3>{{trans('app.HomePageCustomizations')}}</h3>
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableHomeSlider')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->slider_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="slider_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="slider_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableFeaturedCategory')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->category_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="category_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="category_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableSmallBanners')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->sbanner_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="sbanner_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="sbanner_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableLatestProducts')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->latestpro_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="latestpro_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="latestpro_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableFeaturedProducts')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->featuredpro_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="featuredpro_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="featuredpro_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableSubscription')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->subscribe_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="subscribe_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="subscribe_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableLargeBanner')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->lbanner_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="lbanner_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="lbanner_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnablePopularProducts')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->popularpro_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="popularpro_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="popularpro_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableBlogSection')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->blogs_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="blogs_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="blogs_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableTestimonialSection')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->testimonial_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="testimonial_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="testimonial_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableBrandLogos')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($pageset[0]->brands_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="brands_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="brands_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" id="website_update" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="payment">
                                <br><br>

                                <div class="ln_solid"></div>
                                <form method="POST" action="settings/payment" class="form-horizontal form-label-left payment_settings" id="website_form">
                                    {{csrf_field()}}
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.PaypalBusinessAccount')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="paypal" type="text" value="{{$setting[0]->paypal_business}}" minlength="3" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.StripeKey')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="stripe_key" type="text" value="{{$setting[0]->stripe_key}}" minlength="3" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.StripeSecretKey')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="stripe_secret" type="text" value="{{$setting[0]->stripe_secret}}" minlength="3" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.MobileMoneyInstruction')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="mobile_money" type="text" value="{{$setting[0]->mobile_money}}" minlength="3" maxlength="150">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.BankInformation')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="bank_wire" required="required" type="text" value="{{$setting[0]->bank_wire}}" minlength="3" maxlength="150">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="tax_information"> {{trans('app.TaxInformation')}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="tax_information" id="tax_information">
                                                <option value="Per Order" <?php if($setting[0]->tax_information == 'Per Order'){ ?>selected<?php } ?>>{{trans('app.PerOrder')}}</option>
                                                <option value="Per Product" <?php if($setting[0]->tax_information == 'Per Product'){ ?>selected<?php } ?>>{{trans('app.PerProduct')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group taxsection">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.Tax')}}(%) <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" id="tax" type="text" value="{{$setting[0]->tax}}"  minlength="1" maxlength="3" onkeypress="return isNumber(event)" >
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="shipping_information"> {{trans('app.ShippingInformation')}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="shipping_information" id="shipping_information">
                                                <option value="Per Order" <?php if($setting[0]->shipping_information == 'Per Order'){ ?>selected<?php } ?>>{{trans('app.PerOrder')}}</option>
                                                <option value="Per Product" <?php if($setting[0]->shipping_information == 'Per Product'){ ?>selected<?php } ?>>{{trans('app.PerProduct')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group shipsection">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title"> {{trans('app.ShippingCost')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" id="shipping_cost" type="text" minlength="2" maxlength="10" value="{{$setting[0]->shipping_cost}}" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h3>{{trans('app.PaymentOptions')}}</h3>
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableStripe')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($setting[0]->stripe_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="stripe_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="stripe_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableMobileMoney')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($setting[0]->mobile_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="mobile_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="mobile_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableCashDelivery')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($setting[0]->cash_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="cash_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="cash_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnablePaypal')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($setting[0]->paypal_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="paypal_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="paypal_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="facebook"> {{trans('app.DisableEnableBank')}}
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    @if($setting[0]->bank_status == 1)
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="bank_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="bank_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" id="website_update" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="pickup">
                                <br><br>
                                <div class="col-md-12">
                                    <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12" style="margin-bottom: 20px;">
                                        <li class="active"><a href="#default_lang_1" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                        @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                        @foreach($current_language as $alllang)
                                            @if($alllang != get_defaultlanguage())
                                                <li class="store_lang"><a href="#{{$alllang}}_1" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <form method="POST" action="settings/pickup" class="form-horizontal form-label-left" id="pickup_location">
                                            {{csrf_field()}}

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="default_lang_1">
                                                    <input type="hidden" name="id" value="{{$setting[0]->id}}">
                                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address"> {{ trans("app.PickUpAddress") }} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="address" minlength="3" maxlength="150" id="pickupaddress">
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach($current_language as $alllang)
                                                    @if($alllang != get_defaultlanguage())
                                                    <div class="tab-pane" id="{{$alllang}}_1">
                                                        <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                        <div class="item form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address"> {{ trans("app.PickUpAddress") }} <span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" class="form-control col-md-7 col-xs-12" name="trans_address[]" minlength="3" maxlength="150">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="item form-group">
                                                <div class="col-md-3 col-md-offset-3">
                                                    <button id="office_update" type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="lead">{{ trans("app.CurrentLocations") }}</p>  
                                    <div class="ln_solid"></div>         
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>{{ trans("app.PickUpAddress") }}</th>
                                                <th>{{ trans("app.Status") }}</th>
                                                <th>{{ trans("app.Action") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pickups as $pickup)
                                          <tr>
                                            <td>
                                                @if(\App\PickUpLocationTranslations::where('langcode',get_defaultlanguage())->where('plocationgid',$pickup->id)->count() > 0)
                                                    {{ \App\PickUpLocationTranslations::where('langcode',get_defaultlanguage())->where('plocationgid',$pickup->id)->first()->address }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($pickup->status == 1)
                                                    <a href="{!! url('admin/pickupstatus') !!}/status/{{$pickup->id}}/0" class="btn btn-success btn-xs">{{ trans("app.Active") }}</a>
                                                @elseif($pickup->status == 0)
                                                    <a href="{!! url('admin/pickupstatus') !!}/status/{{$pickup->id}}/1" class="btn btn-danger btn-xs">{{ trans("app.Deactive") }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown display-ib">
                                                    <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                                    <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                        <li>
                                                            <a href="#" onclick="return delete_pickaddr('{{$pickup->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">{{trans('app.Delete')}} </span></a>
                                                        </li>
                                                    </ul>  
                                                </div>
                                            </td>
                                          </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="background">
                                <br><br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="settings/background" class="form-horizontal form-label-left" enctype="multipart/form-data" id="background_form">
                                    {{csrf_field()}}
                                    @if($setting[0]->background != '')
                                    <div class="item form-group loadDiv">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CurrentImage')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img class="col-md-10" src="../assets/images/{{$setting[0]->background}}">
                                        </div>
                                    </div><br>
                                    @endif
                                    <!-- <input type="hidden" name="id" value="1"> -->
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ChangeImage')}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                            <input type="file" name="background" required="required" accept="image/*" id="file" onchange="readURL(this);"/>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="about">
                                <br><br>

                                <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12" style="margin-bottom: 20px;">
                                    <li class="active"><a href="#default_lang_2" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                    @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                    @foreach($current_language as $alllang)
                                        @if($alllang != get_defaultlanguage())
                                            <li class="store_lang"><a href="#{{$alllang}}_2" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>

                                <div class="ln_solid"></div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <form method="POST" action="settings/about" class="form-horizontal form-label-left" id="about_form">
                                        {{csrf_field()}}

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="default_lang_2">
                                                <input type="hidden" name="id" value="{{$setting[0]->id}}">
                                                <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                @php 
                                                    $about = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $about = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->about; 
                                                    @endphp
                                                @endif
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="about"> {{trans('app.AboutUsText')}} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea rows="10" cols="60" id="abouttext" class="form-control" name="about" minlength="3" maxlength="255">{{$about}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($current_language as $alllang)
                                                @if($alllang != get_defaultlanguage())
                                                @php 
                                                    $about = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $about = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->about; 
                                                    @endphp
                                                @endif
                                                <div class="tab-pane" id="{{$alllang}}_2">
                                                    <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.AboutUsText')}} <span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea rows="10" cols="60" id="abouttext" class="form-control" name="trans_about[]" minlength="3" maxlength="255">{{$about}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button type="submit" id="about_update" class="btn btn-success">{{trans('app.Save')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="address">
                                <br><br>

                                <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12" style="margin-bottom: 20px;">
                                    <li class="active"><a href="#default_lang_address" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                    @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                    @foreach($current_language as $alllang)
                                        @if($alllang != get_defaultlanguage())
                                            <li class="store_lang"><a href="#{{$alllang}}_address" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>

                                <div class="ln_solid"></div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <form method="POST" action="settings/address" class="form-horizontal form-label-left" id="ofaddr_form">
                                        {{csrf_field()}}
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="default_lang_address">
                                                <input type="hidden" name="id" value="{{$setting[0]->id}}">
                                                <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                @php 
                                                    $address = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $address = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->address; 
                                                    @endphp
                                                @endif

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address"> {{trans('app.StreetAddress')}} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea rows="3" cols="60" class="form-control col-md-7 col-xs-12" name="address" minlength="3" maxlength="150" id="office_address">{{$address}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">{{trans('app.Phone')}} <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="phone" placeholder="Phone Number" type="text" onkeypress="return isNumber(event)" value="{{$setting[0]->phone}}" minlength="10" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> {{trans('app.Email')}} <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="email" placeholder="Email Address" type="text" value="{{$setting[0]->email}}" minlength="3" maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($current_language as $alllang)
                                                @if($alllang != get_defaultlanguage())
                                                @php 
                                                    $address = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $address = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->address; 
                                                    @endphp
                                                @endif
                                                <div class="tab-pane" id="{{$alllang}}_address">
                                                    <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.StreetAddress')}} <span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea rows="3" cols="60" class="form-control col-md-7 col-xs-12" name="trans_address[]" minlength="3" maxlength="150" id="office_address_{{$alllang}}">{{$address}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="office_update" type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="footer">
                                <br><br>

                                <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12" style="margin-bottom: 20px;">
                                    <li class="active"><a href="#default_lang_footer" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                    @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                    @foreach($current_language as $alllang)
                                        @if($alllang != get_defaultlanguage())
                                            <li class="store_lang"><a href="#{{$alllang}}_footer" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>

                                <div class="ln_solid"></div>

                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <form method="POST" action="settings/footer" class="form-horizontal form-label-left" id="footer_form">
                                        {{csrf_field()}}
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="default_lang_footer">
                                                <input type="hidden" name="id" value="{{$setting[0]->id}}">
                                                <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                @php 
                                                    $footer = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $footer = \App\SettingsTranslations::where('langcode',get_defaultlanguage())->where('settingid',$setting[0]->id)->first()->footer; 
                                                    @endphp
                                                @endif
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer">{{trans('app.FooterText')}} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea rows="2" cols="60" id="footerpnael" class="form-control" name="footer" minlength="3" maxlength="255">{{$footer}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach($current_language as $alllang)
                                                @if($alllang != get_defaultlanguage())
                                                @php 
                                                    $footer = ''; 
                                                @endphp
                                                @if(\App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->count() > 0)
                                                    @php 
                                                        $footer = \App\SettingsTranslations::where('langcode',$alllang)->where('settingid',$setting[0]->id)->first()->footer; 
                                                    @endphp
                                                @endif
                                                <div class="tab-pane" id="{{$alllang}}_footer">
                                                    <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.FooterText')}} <span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea rows="2" cols="60" id="footerpnael_{{$alllang}}" class="form-control" name="trans_footer[]" minlength="3" maxlength="255">{{$footer}}</textarea> 
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="footer_update" type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="langsettings">
                                <br><br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="settings/selectlanguage" class="form-horizontal form-label-left" id="footer_form">
                                    {{csrf_field()}}

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer"> {{trans('app.DefaultLanguage')}} <span class="required">*</span>
                                        </label>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                            <select name="default_language" class="form-control">
                                                @foreach($slanguage as $alllang)
                                                    @if(in_array($alllang->code, $current_language))
                                                        <option value="{{$alllang->code}}" @if($alllang->code == $companydetails[0]->default_language) selected @endif>{{$alllang->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer"> {{trans('app.SelectLanguage')}} <span class="required">*</span>
                                        </label>

                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                            @foreach($slanguage as $alllang)
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input type="checkbox" class="custom-control-input" name="language[]" value="{{$alllang->code}}" @if(in_array($alllang->code, $current_language)) checked @endif >&nbsp;<img src="{{url('/assets/images/language')}}/{{$alllang->image}}" width="20" height="15"> <label class="language_label">{{$alllang->name}}</label>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button id="language_update" type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.end -->
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

    function delete_pickaddr(reportid)
    {
        if(confirm(DeleteConfirmation))
        {   
            window.location = "settings/pickup-del/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    $(document).ready(function(){

        $('.form-group .toggle.btn').css('width','100px');

        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, ValidEmailError);

        var data = $('#shipping_information').val(); 
        if(data == 'Per Order')
        {
            $('.shipsection').show();
            $('#shipping_cost').attr('name','shipping_cost');
        }
        else
        {
            $('.shipsection').hide();
        }
        $('#shipping_information').change(function(){
            var data = $('#shipping_information').val(); 
            if(data == 'Per Order')
            {
                $('.shipsection').show();
                $('#shipping_cost').attr('name','shipping_cost');
            }
            else
            {
                $('.shipsection').hide();
                $('#shipping_cost').removeAttr('name','shipping_cost');
            }
        });

        var data = $('#tax_information').val(); 
        if(data == 'Per Order')
        {
            $('.taxsection').show();
            $('#tax').attr('name','tax');
        }
        else
        {
            $('.taxsection').hide();
        }
        $('#tax_information').change(function(){
            var data = $('#tax_information').val(); 
            if(data == 'Per Order')
            {
                $('.taxsection').show();
                $('#tax').attr('name','tax');
            }
            else
            {
                $('.taxsection').hide();
                $('#tax').removeAttr('name','tax');
            }
        });

        $('#logo_form').validate({
            rules:{
                logo:{
                    required:true,
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

        $('#website_favicon').validate({
            rules:{
                favicon:{
                    required:true,
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

        $('#background_form').validate({
            rules:{
                background:{
                    required:true,
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

        $('.website_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                popular_tags:{
                   required:true, 
                },
                currency_sign:{
                    required:true, 
                }
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

        if ($(".website_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('.title_input').on('blur keyup', function() {
            if ($(".website_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

        $('.payment_settings').validate({
            rules:{
                paypal:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                stripe_key:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                stripe_secret:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                mobile_money:{
                    required:true,
                    minlength: 3,
                    maxlength: 150,
                },
                bank_wire:{
                    required:true,
                    minlength: 3,
                    maxlength: 150,
                },
                tax_information:{
                    required:true,
                },
                tax:{
                    required:true,
                    number:true,
                    max:100,
                    min:0
                },
                shipping_information:{
                    required:true,
                },
                shipping_cost:{
                    required:true,
                    number:true,
                    minlength:2,
                    maxlength:10
                },
            },
            messages:{
                shipping_cost:{
                    minlength: MinTwoDecimalPlaces,
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

        $('#pickup_location').validate({
            rules:{
                address:{
                    required:true,
                    minlength: 3,
                    maxlength: 150,
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

        if ($("#pickup_location").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input#pickupaddress').on('blur keyup', function() {
            if ($("#pickup_location").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        }); 

        $('#about_form').validate({
            rules:{
                about:{
                    required:true,
                    minlength: 3,
                    maxlength: 255,
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

        if ($("#about_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('textarea#abouttext').on('blur keyup', function() {
            if ($("#about_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        }); 

        $('#ofaddr_form').validate({
            rules:{
                address:{
                    required:true,
                    minlength: 3,
                    maxlength: 150,
                },
                phone:{
                    required:true,
                    minlength: 10,
                    maxlength: 10,
                    number:true
                },
                email:{
                    required:true,
                    Validemail: true,
                    minlength: 3,
                    maxlength: 100,
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

        if ($("#ofaddr_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('textarea#office_address').on('blur keyup', function() {
            if ($("#ofaddr_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });

        $('#footer_form').validate({
            rules:{
                footer:{
                    required:true,
                    minlength: 3,
                    maxlength: 255,
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

        if ($("#footer_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('textarea#footerpnael').on('blur keyup', function() {
            if ($("#footer_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });

    });
</script>
@stop