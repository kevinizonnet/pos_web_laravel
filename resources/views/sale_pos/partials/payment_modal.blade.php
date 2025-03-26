<div class="modal fade" tabindex="-1" role="dialog" id="modal_payment">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">@lang('lang_v1.payment')</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 mb-12">
						<strong>@lang('lang_v1.advance_balance'):</strong> <span id="advance_balance_text"></span>
						{!! Form::hidden('advance_balance', null, ['id' => 'advance_balance', 'data-error-msg' => __('lang_v1.required_advance_balance_not_available')]); !!}
					</div>
					<div class="col-md-9">
						<div class="row">
							<div id="payment_rows_div">
								@foreach($payment_lines as $payment_line)
									
									@if($payment_line['is_return'] == 1)
										@php
											$change_return = $payment_line;
										@endphp

										@continue
									@endif

									@include('sale_pos.partials.payment_row', ['removable' => !$loop->first, 'row_index' => $loop->index, 'payment_line' => $payment_line])
								@endforeach
							</div>
							<input type="hidden" id="payment_row_index" value="{{count($payment_lines)}}">
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-primary btn-block" id="add-payment-row">@lang('sale.add_payment_row')</button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('sale_note', __('sale.sell_note') . ':') !!}
									{!! Form::textarea('sale_note', !empty($transaction)? $transaction->additional_notes:null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('sale.sell_note')]); !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('staff_note', __('sale.staff_note') . ':') !!}
									{!! Form::textarea('staff_note', 
									!empty($transaction)? $transaction->staff_note:null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('sale.staff_note')]); !!}
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box box-solid bg-orange">
				            <div class="box-body">
				            	<div class="col-md-12">
				            		<strong>
				            			@lang('lang_v1.total_items'):
				            		</strong>
				            		<br/>
				            		<span class="lead text-bold total_quantity">0</span>
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			@lang('sale.total_payable'):
				            		</strong>
				            		<br/>
				            		<span class="lead text-bold total_payable_span">0</span>
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			@lang('lang_v1.total_paying'):
				            		</strong>
				            		<br/>
				            		<span class="lead text-bold total_paying">0</span>
				            		<input type="hidden" id="total_paying_input">
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			@lang('lang_v1.change_return'):
				            		</strong>
				            		<br/>
				            		<span class="lead text-bold change_return_span">0</span>
				            		{!! Form::hidden("change_return", $change_return['amount'], ['class' => 'form-control change_return input_number', 'required', 'id' => "change_return"]); !!}
				            		<!-- <span class="lead text-bold total_quantity">0</span> -->
				            		@if(!empty($change_return['id']))
				                		<input type="hidden" name="change_return_id" 
				                		value="{{$change_return['id']}}">
				                	@endif
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			@lang('lang_v1.balance'):
				            		</strong>
				            		<br/>
				            		<span class="lead text-bold balance_due">0</span>
				            		<input type="hidden" id="in_balance_due" value=0>
				            	</div>


				            					              
				            </div>
				            <!-- /.box-body -->
				          </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
				<button type="submit" class="btn btn-primary" id="pos-save">@lang('sale.finalize_payment')</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Used for express checkout card transaction -->
<div class="modal fade" tabindex="-1" role="dialog" id="card_details_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">@lang('lang_v1.card_transaction_details')</h4>
				<input type="hidden" name="payType">
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label("card_number", __('lang_v1.card_no')) !!}
				{!! Form::text("", null, ['class' => 'form-control', 'minlength' => '16', 'maxlength' => '16', 'placeholder' => __('lang_v1.card_no'), 'id' => "card_number", 'autofocus', 'required']); !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label("card_holder_name", __('lang_v1.card_holder_name')) !!}
				{!! Form::text("", null, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_holder_name'), 'id' => "card_holder_name", 'autofocus', 'required']); !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label("card_transaction_number",__('lang_v1.card_transaction_no')) !!}
				{!! Form::text("", null, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_transaction_no'), 'id' => "card_transaction_number", 'required']); !!}
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-3">
			<div class="form-group">
				{!! Form::label("card_type", __('lang_v1.card_type')) !!}
				{!! Form::select("", ['visa' => 'Visa', 'master' => 'MasterCard'], 'visa',['class' => 'form-control select2', 'id' => "card_type" ]); !!}
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				{!! Form::label("card_month", __('lang_v1.month')) !!}
				{!! Form::number("", null, ['class' => 'form-control', 'minlength' => '1', 'maxlength' => '2', 'placeholder' => __('lang_v1.month'),
				'id' => "card_month", 'required' ]); !!}
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				{!! Form::label("card_year", __('lang_v1.year')) !!}
				{!! Form::number("", null, ['class' => 'form-control', 'minlength' => '4', 'maxlength' => '4', 'placeholder' => __('lang_v1.year'), 'id' => "card_year", 'required' ]); !!}
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				{!! Form::label("card_security",__('lang_v1.security_code')) !!}
				{!! Form::text("", null, ['class' => 'form-control', 'minlength' => '3', 'maxlength' => '4', 'placeholder' => __('lang_v1.security_code'), 'id' => "card_security", 'required']); !!}
			</div>
		</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="pos-save-card">@lang('sale.finalize_payment')</button>
			</div>

		</div>
	</div>

</div>
<div class="modal fade" tabindex="-1" role="dialog" id="paymentTypeModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="margin-top: 15%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center font-weight-bold" id="paymentTypeModalLabel">Select Payment Type</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-7 text-center">
						<a href="javascript:void(0)" class="btn btn-success btn-wd btn-lg selectedOpt" data-value="manual">Manually Card Enter</a>
					</div>
					<div class="col-md-5 text-center">
						<a href="javascript:void(0)" class="btn btn-success btn-wd btn-lg selectedOpt swipe" data-value="swipe">Insert/Swipe</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default cancelPay" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="payWithCashModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center font-weight-bold" id="payWithCashModalLabel">Accounts</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="total_sale">Total Sale</label>
							<input type="text" class="form-control" id="total_sale" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="total_tender">Total Tender</label>
							<input type="number" class="form-control" id="total_tender" name="total_tender" value="0">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="change_due">Change Due</label>
							<input type="number" class="form-control" name="change_due" id="change_due" readonly value="0">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
				<button type="button" class="btn btn-success cashPay">Pay Now</button>
			</div>
		</div>
	</div>
</div>