@extends('layouts.guest')
@section('title', $title)
@section('content')

<div class="container">
    <div class="spacer"></div>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <div class="box box-primary">
                <div class="box-body">
                    <table class="table no-border">
                        <tr>
                            @if(!empty($transaction->business->logo))
                                <td class="width-50 text-center">
                                    <img src="{{ asset( 'uploads/business_logos/' . $transaction->business->logo ) }}" alt="Logo" style="max-width: 80%;">
                                </td>
                            @endif
                            <td class="text-center">
                                <address>
                                <strong>{{ $transaction->business->name }}</strong><br>
                                {{ $transaction->location->name ?? '' }}
                                @if(!empty($transaction->location->landmark))
                                    <br>{{$transaction->location->landmark}}
                                @endif
                                @if(!empty($transaction->location->city) || !empty($transaction->location->state) || !empty($transaction->location->country))
                                    <br>{{implode(',', array_filter([$transaction->location->city, $transaction->location->state, $transaction->location->country]))}}
                                @endif
                              
                                @if(!empty($transaction->business->tax_number_1))
                                    <br>{{$transaction->business->tax_label_1}}: {{$transaction->business->tax_number_1}}
                                @endif

                                @if(!empty($transaction->business->tax_number_2))
                                    <br>{{$transaction->business->tax_label_2}}: {{$transaction->business->tax_number_2}}
                                @endif

                                @if(!empty($transaction->location->mobile))
                                    <br>@lang('contact.mobile'): {{$transaction->location->mobile}}
                                @endif
                                @if(!empty($transaction->location->email))
                                    <br>@lang('business.email'): {{$transaction->location->email}}
                                @endif
                            </address>
                            </td>
                        </tr>
                    </table>
                    <h4 class="box-title">@lang('lang_v1.payment_for_invoice_no'): {{$transaction->invoice_no}}</h4>
                    <table class="table no-border">
                        <tr>
                            <td>
                                <strong>@lang('contact.customer'):</strong><br>
                                {!!$transaction->contact->contact_address!!}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>@lang('sale.sale_date'):</strong> {{$date_formatted}}</td>
                        </tr>
                        <tr>
                            <td>
                                <h4>@lang('sale.total_amount'): <span>{{$total_amount}}</span></h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>@lang('sale.total_paid'): <span>{{$total_paid}}</span></h4>
                            </td>
                        </tr>
                    </table>

                    @if($transaction->payment_status != 'paid')
                    <table class="table no-border">
                        <tr>
                            <td><h4>@lang('sale.total_payable'): <span>{{$total_payable_formatted}}</span></h4></td>
                        </tr>
                    </table>
                    <div class="spacer"></div>
                    <div class="spacer"></div>
                    <div class="width-50 text-center f-left">
                        <form action="{{route('confirm_payment', ['id' => $transaction->id])}}" method="POST">
                            <input type="hidden" name="gateway" value="razorpay">
                                <!-- Note that the amount is in paise -->
                            <script
                                src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{$pos_settings['razor_pay_key_id']}}"
                                data-amount="{{$total_payable*100}}"
                                data-buttontext="Pay with Razorpay"
                                data-name="{{$transaction->business->name}}"
                                data-theme.color="#3c8dbc"
                            ></script>
                            {{ csrf_field() }}
                        </form>
                    </div>
                        @if(!empty($pos_settings['stripe_public_key']) && !empty($pos_settings['stripe_secret_key']))
                            @php
                                $code = strtolower($business_details->currency_code);
                            @endphp

                            <div class="width-50 text-center f-left">
                                <form action="{{route('confirm_payment', ['id' => $transaction->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="gateway" value="stripe">
                                    <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="{{$pos_settings['stripe_public_key']}}"
                                            data-amount="@if(in_array($code, ['bif','clp','djf','gnf','jpy','kmf','krw','mga','pyg','rwf','ugx','vnd','vuv','xaf','xof','xpf'])) {{$total_payable}} @else {{$total_payable*100}} @endif"
                                            data-name="{{$transaction->business->name}}"
                                            data-description="Pay with stripe"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto"
                                            data-currency="{{$code}}">
                                    </script>
                                </form>
                            </div>
                        @endif
                        @if(!empty($pos_settings['nmi_terminal_id']) && !empty($pos_settings['nmi_security_key']))
                            @php
                                $code = strtolower($business_details->currency_code);
                            @endphp

                            <div class="width-50 text-center f-left">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nmiModal">
                            Pay with NMI
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="nmiModal" tabindex="-1" role="dialog" aria-labelledby="nmiModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nmiModalLabel">
                                                Reveal POS <br>
                                                <span>Pay with NMI</span>
                                            </h5>
                                        </div>
                                        <form id="nmi_form" action="{{route('confirm_payment', ['id' => $transaction->id])}}" method="POST">
                                        
                                            {{ csrf_field() }}

                                            <input type="hidden" name="gateway" value="nmi">
                                            <input type="hidden" name="currency" value="{{ $code }}">
                                            <input type="hidden" name="amount" value="{{$total_amount}}">
                                        
                                            <div class="modal-body">
                                                
                                                <!-- <h4 class="f-left">Card Information</h4> -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="ccnumber">Card Number:</label>
                                                            <input type="text" class="form-control" name="ccnumber" value="4111111111111111" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ccexp">MM/YY:</label>
                                                            <input type="month" class="form-control" name="ccexp" value="Test" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cvv">CVV:</label>
                                                            <input type="number" class="form-control" name="cvv" value="123" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="f-left">Billing Information</h4>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fname">First Name:</label>
                                                            <input type="text" class="form-control" name="fname" value="Test" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lname">Last Name:</label>
                                                            <input type="text" class="form-control" name="lname" value="Test" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Email:</label>
                                                            <input type="email" class="form-control" name="email" value="support@example.com" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address1">Address 1:</label>
                                                            <input type="text" class="form-control" name="address1" value="address1" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address2">Address 2:</label>
                                                            <input type="text" class="form-control" name="address2" value="address2" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="city">City:</label>
                                                            <input type="text" class="form-control" name="city" value="city" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="state">State:</label>
                                                            <input type="text" class="form-control" name="state" value="state" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="country">Country:</label>
                                                            <input type="text" class="form-control" name="country" value="country" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="zip">Zip:</label>
                                                            <input type="text" class="form-control" name="zip" value="zip" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone">Phone:</label>
                                                            <input type="tel" class="form-control" name="phone" value="phone" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="company">Company:</label>
                                                            <input type="text" class="form-control" name="company" value="Test" />
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- <table>
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td><input size="30" type="text" name="fname" value="Test" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Name</td>
                                                        <td><input size="30" type="text" name="lname" value="User" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td><input size="30" type="text" name="address" value="123 Main Street"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>City</td>
                                                        <td><input size="30" type="text" name="city" value="Beverley Hills"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <td><input size="30" type="text" name="state" value="CA"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Zip</td>
                                                        <td><input size="30" type="text" name="zip" value="90210"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country</td>
                                                        <td><input size="30" type="text" name="country" value="US"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td><input size="30" type="text" name="phone" value="5555555555"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <div id="googlepaybutton"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <div id="applepaybutton"></div>
                                                        </td>
                                                    </tr>

                                                </table>
                                                <br>
                                                <button class="customPayButton" type="button">Pay the money.</button> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Pay</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <table class="table no-border">
                            <tr>
                                <td><h4>@lang('sale.payment_status'): <span class="text-success">@lang('lang_v1.paid')</span></h4></td>
                            </tr>
                        </table>
                    @endif
                    <div class="spacer"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
    $(document).on('submit', '#nmi_form', function(e){
        e.preventDefault();
        //console.log($(this).serialize())
        
        $.ajax({
          url: $(this).attr('action'),
          type: $(this).attr('method'),
          data: $(this).serialize(),
          success:function(response){
            console.log(response);
            if (response) {
               
              //$("#nmi_form")[0].reset(); 
            }
          },
          error: function(response) {
            console.log(response.responseText)
           }
         });
        });
</script>
@endsection