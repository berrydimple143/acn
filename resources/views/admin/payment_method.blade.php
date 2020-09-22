@extends('layouts.admin')
@section('title', 'Payment Method')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-group"></i> Payment Method</h3>   
  </div>
  <div class="panel-body">	
	{!! Form::open(['route' => 'process.pay', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
		<input type="hidden" name="cmd" value="{{ $cmd }}">
		<input type="hidden" name="business" value="{{ $business }}">
		<input type="hidden" name="item_name" value="{{ $item_name }}">
		<input type="hidden" name="membership" value="{{ $membership }}">
		<input type="hidden" name="on0" value="{{ $on0 }}">
		<input type="hidden" name="os0" value="{{ $os0 }}">
		<input type="hidden" name="image_url" value="{{ $image_url }}">
		<input type="hidden" name="currency_code" value="{{ $currency_code }}">		
		<input type="hidden" name="a1" value="{{ $a1 }}">
		<input type="hidden" name="p1" value="{{ $p1 }}">
		<input type="hidden" name="t1" value="{{ $t1 }}">		
		<input type="hidden" name="a2" value="{{ $a2 }}">
		<input type="hidden" name="p2" value="{{ $p2 }}">
		<input type="hidden" name="t2" value="{{ $t2 }}">		
		<input type="hidden" name="a3" value="{{ $a3 }}">
		<input type="hidden" name="p3" value="{{ $p3 }}">
		<input type="hidden" name="t3" value="{{ $t3 }}">
		<input type="hidden" name="return" value="{{ $return }}">
		<input type="hidden" name="cancel_return" value="{{ $cancel_return }}">
		<input type="hidden" name="src" value="{{ $src }}">
		<input type="hidden" name="sra" value="{{ $sra }}">
		<input type="hidden" name="receiver_email" value="{{ $receiver_email }}">
		<input type="hidden" name="no_shipping" value="{{ $no_shipping }}">
		<input type="hidden" name="no_note" value="{{ $no_note }}">
		<input type="hidden" name="on1" value="{{ $on1 }}">
		<input type="hidden" name="mrb" value="{{ $mrb }}">
		<input type="hidden" name="pal" value="{{ $pal }}">
		<input type="hidden" name="subscription" value="{{ $subscription }}">
		<input type="hidden" name="price" value="{{ $price }}">		
		<div class="row">		
			<div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-10">
				<div class="form-group">
					{{ Form::label('payment_type', 'Choose Type', ['class' => 'col-sm-3 control-label']) }}					
					<div class="col-sm-9">			    	
						<select name="payment_type" id="payment_type" class="form-control input-sm" required>
							<option value="">-- Select Type --</option>
							<option value="paypal">Paypal</option>
							<option value="creditcard">Credit Card</option>
						</select>					
					</div>
				</div>
			</div>
			<div class="col-sm-1">&nbsp;</div>
		</div>
		<div id="card-info">
			<div class="row">&nbsp;</div>
			<div class="row">		
				<div class="col-sm-6">
					<div class="form-group">
						{{ Form::label('cardno', 'Card Number', ['class' => 'col-sm-4 control-label']) }}					
						<div class="col-sm-8">			    	
							<div class="input-group">
								{{ Form::text('cardno', null, ['class' => 'form-control input-sm', 'id' => 'cardno', 'placeholder' => 'Card Number here ...']) }}					
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
							</div>					
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						{{ Form::label('cvv', 'CVV Number', ['class' => 'col-sm-4 control-label']) }}					
						<div class="col-sm-8">			    	
							<div class="input-group">
								{{ Form::text('cvv', null, ['class' => 'form-control input-sm', 'id' => 'cvv', 'placeholder' => 'CVV Number here ...']) }}					
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
							</div>					
						</div>
					</div>
				</div>				
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">		
				<div class="col-sm-6">
					<div class="form-group">
						{{ Form::label('xmonth', 'Expiration Month', ['class' => 'col-sm-4 control-label']) }}					
						<div class="col-sm-8">			    	
							<select name="xmonth" id="xmonth" class="form-control input-sm">								
								<?php for($i=1; $i<=12; $i++) : ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php endfor; ?>
							</select>					
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						{{ Form::label('xyear', 'Expiration Year', ['class' => 'col-sm-4 control-label']) }}					
						<div class="col-sm-8">			    	
							<select name="xyear" id="xyear" class="form-control input-sm">								
								<?php for($j=$yearfrom; $j<=$yearto; $j++) : ?>
										<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
								<?php endfor; ?>
							</select>					
						</div>
					</div>
				</div>				
			</div>
		</div>
		<div class="row">&nbsp;</div>		
		<div class="row">		
			<div class="col-sm-4">&nbsp;</div>
			<div class="col-sm-4">
				<div class="form-group">
					<button type="submit" class="btn btn-block btn-social btn-facebook btn-flat" id="gotoportal"><i class="fa fa-hand-o-right"></i> Proceed</button>
				</div>
			</div>
			<div class="col-sm-4">&nbsp;</div>
		</div>	
		<div class="row">&nbsp;</div>	
	{!! Form::close() !!}
  </div> 
</div>
@endsection