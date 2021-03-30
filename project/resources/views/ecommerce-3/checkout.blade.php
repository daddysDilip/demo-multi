@extends('ecommerce-3.includes.newmaster')

@section('content')
    <main>
      <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>Checkout</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section id="checkout">
        <div class="container">
          <div class="row">
            <div class="col-md-9 detail_box">
              <div class="clearfix"></div>
              <div class="checkbox">
                  <label data-toggle="collapse" data-target="#promo">
                      <input type="checkbox"> I have a promo code
                  </label>
              </div>
              <div class="collapse" id="promo">
                <div class="form-group">
                  <label for="inputpromo" class="control-label">Promo Code</label>
                  <div class="form-inline">
                    <input type="text" class="form-control" id="inputpromo" placeholder="Enter promo code">
                    <button class="btn btn-sm">Apply</button>
                  </div>
                </div>
              </div>
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h3 class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <a>
                      1 Personal Information
                    </a>
                  </h3>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <h2>Order as a Guest | <a href="#0">Log In</a></h2>
                      <div class="row">
                       <div class="col-md-12">
                         <form class="form-horizontal">
                           <fieldset >
                            <div class="control-group">
                            <div class="controls">
                              <label class="control-label"  for="username">Title <span>*</span></label>
                              <div class="radio_box">
                                <input type="radio" id="username" name="title" placeholder="">
                                <label>Male</label>
                              </div>
                              <div class="radio_box">
                                <input type="radio" id="username" name="title" placeholder="">
                                <label>Female</label>
                              </div>
                            </div>
                          </div>
                          <div class="control-group">
                            <div class="controls">
                              <label class="control-label"  for="username">First Name <span>*</span></label>
                              <input type="text" id="username" name="" placeholder="" class="input-xlarge">
                            </div>
                          </div>
                          <div class="control-group">
                            <div class="controls">
                              <label class="control-label"  for="username">Last Name <span>*</span></label>
                              <input type="text" id="username" name="" placeholder="" class="input-xlarge">
                            </div>
                          </div>
                          <div class="control-group">
                            <div class="controls">
                              <label class="control-label"  for="username">Email <span>*</span></label>
                              <input type="email" id="username" name="" placeholder="" class="input-xlarge">
                            </div>
                          </div>
                          <div class="control-group">
                            <div class="controls">
                              <button>CONTINUE</button>
                            </div>
                          </div>
                        </fieldset>
                         </form>
                       </div>
                     </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h3 class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <a>
                      2 Addresses
                    </a>
                  </h3>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <div class="list-group">
                        <div class="list-group-item">
                          <div class="list-group-item-heading">          
                              <div class="row radio">
                                <div class="col-md-3">
                                  <label>
                                    <input type="radio" name="optionShipp" id="optionShipp1" value="option2">
                                    1509 Latona St
                                  </label>
                                </div>
                                <div class="col-md-5">
                                  <dl class="dl-small">
                                    <dt>Miguel Perez</dt>
                                    <dd>1509 Latona St, Philadelphia, PA 19146 </dd>
                                  </dl>
                                  <button class="btn btn-sm">Edit</button>
                                  <button class="btn btn-sm btn-link">Delete this address</button>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="list-group-item-heading">          
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="radio">
                                    <label>
                                      <input type="radio" name="optionShipp" id="optionShipp2" value="option2" checked>
                                      A new address
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-9">                      
                                  <form role="form" class="">
                                    <div class="form-group">
                                      <label for="inputname">Name</label>
                                      <input type="text" class="form-control form-control-large" id="inputname" placeholder="Enter name">
                                    </div>
                                    <div class="form-group">
                                      <label for="inputAddress1">Street address 1</label>
                                      <input type="text" class="form-control form-control-large" id="inputAddress1" placeholder="Enter address">
                                    </div>
                                    <div class="form-group">
                                      <label for="inputAddress2">Street address 2</label>
                                      <input type="text" class="form-control form-control-large" id="inputAddress2" placeholder="Enter address">
                                    </div>
                                    <div class="row">
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="inputZip">ZIP Code</label>
                                          <input type="text" class="form-control form-control-small" id="inputZip" placeholder="Enter zip">
                                        </div>
                                      </div>
                                      <div class="col-md-9">
                                        <div class="form-group">
                                          <label for="inputCity">City</label>
                                          <input type="text" class="form-control" id="inputCity" placeholder="Enter city">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="inputState" class="control-label">State</label>
                                      <select class="form-control form-control-large">
                                        <option>Select state</option>
                                      </select>
                                    </div>
                                  </form>
                                  <button class="btn btn-sm">Save Address</button>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h3 class="panel-title collapsed"role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <a >
                      3 Shipping Method 
                    </a>
                  </h3>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                      on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
                      raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree" >
                    <h3 class="panel-title" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <a>
                      4 Payment
                    </a>
                  </h3>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseFour">
                    <div class="panel-body">
                      <div class="list-group">
                        <div class="list-group-item">
                          <div class="list-group-item-heading">          
                              <div class="row radio">
                                <div class="col-md-3">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>
                                    My Visa Card
                                  </label>
                                </div>
                                <div class="col-md-9">
                                  <div class="row">
                                    <div class="col-md-4">                      
                                      <dl class="dl-small">
                                        <dt>Credit Card Number</dt>
                                        <dd>**********1111</dd>
                                      </dl>
                                    </div>
                                    <div class="col-md-2">
                                      <dl class="dl-small">
                                        <dt>Expiration</dt>
                                        <dd>07/2016</dd>
                                      </dl>
                                    </div>
                                    <div class="col-md-6">
                                      <dl class="dl-small">
                                        <dt>Billing Address</dt>
                                        <dd>1509 Latona St, Philadelphia, PA 19146 </dd>
                                      </dl>
                                    </div>
                                  </div>
                                  <button class="btn btn-sm">Edit</button>
                                  <button class="btn btn-sm btn-link">Delete this card</button>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="list-group-item-heading">          
                              <div class="row radio">
                                <div class="col-md-3">
                                  <label data-toggl-e="collapse" data-target="#newcard">
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    A New Credit Card
                                  </label>
                                </div>
                                <div class="col-md-9">                      
                                  <div class="media">
                                    <a class="media-left" href="#">
                                      <img src="https://lovewithfood.com/assets/credit_cards/cards-b3a7c7b8345355bf110ebedfd6401312.png" height="25" alt="" />
                                    </a>
                                    <div class="media-body" id="newcard">
                                      We accept these credit cards.
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="list-group-item-heading">          
                              <div class="row radio">
                                <div class="col-md-3">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    PayPal
                                  </label>
                                </div>
                                <div class="col-md-9">                      
                                  <div class="media">
                                    <a class="media-left" href="#">
                                      <img src="https://www.paypalobjects.com/webstatic/mktg/logo-center/PP_Acceptance_Marks_for_LogoCenter_76x48.png" height="25" alt="" />
                                    </a>
                                    <div class="media-body">
                                      When you click "Place Order", you will be taken to the PayPal website.
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="detail_box">
                <div><span class="heading">1 item</span><span class="price_tt"><i class="fas fa-rupee-sign"></i> 8500.00</span></div>
                <div><span class="heading">Shipping</span><span class="price_tt"><i class="fas fa-rupee-sign"></i> 150.00</span></div>
                <div class="seprator mar_sap"></div>
                <div><span class="heading">Total</span><span class="price_tt"><i class="fas fa-rupee-sign"></i> 9650.00</span></div>
                <div><span class="heading">Taxes</span><span class="price_tt"><i class="fas fa-rupee-sign"></i> 00.00</span></div>
                <div class="seprator mar_sap"></div>
                <div class="text-center"><a href="#0" class="checkout">Proceed to checkout</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    @endsection
  