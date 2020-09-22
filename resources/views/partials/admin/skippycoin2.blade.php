<?php 
	$sk = App\Skippycoin::where('status', '!=', '')->first();
	$skippycoin = $sk->status;
?>

@if($wallet != "")
<div class="row">
  <div class="col-sm-12 text-center">
    <div align="center"><img src="/images/SKC-240.png" alt="Skippycoin" /></div>
    <div align="center">
      <h3>Imagine if we the people own our own coin</h3>
      One Skippycoin contains 1000 Roo and each Roo contains 1000 Joey.. That's how many Joey?
      <hr>
      <h4><font color="#009966">Your validated Skippywallet Address is<br>
        <br>
        {{ $wallet }}</font></h4>
      <hr>
      <strong>Keep your Skippywallet address up to date in the Account Settings menu<br>
      Members receive extra Skippycoin when you list your Business or Community Group and while we have ample coin to hand out this will be sent by the Payment Bot daily to the valid Skippywallet address that is listed here<br />
      <br>
      <h3>Digital Assettes are emerging worldwide it is clearly the future</h3>
      Why are we sending huge Australian Wealth overseas when we are smart enough to do this?<br />WE CAN DO IT!<br />We have given away our Automotive Industry, our Mining Industry, we have given away our Gold and our very land and so much more, let's not give away our Australian Crypto!
      <hr>
      The extra daily Skippycoin will only be sent to members who have paid accounts.<br />
      How? <br />
      LIST YOUR AUSTRALIAN BUSINESS OR COMMUNITY GROUP<br />
      To keep our coin in our country share of Skippycoin is gifted only to Australians via multifactor validation via the <a href="http://skippybook.com" target="_blank" rel="nofollow">Skippybook</a> or by listing your genuine Australian Business or Community Group here. Be sure to list your Business with a valid ABN or ACN in your profile </div>
  </div>
</div>
@else
<div class="col-sm-12 text-center">
  <?php if ($skippycoin == 'off')
		{
		echo '<font color="#FF0000"><h3>AUSTRALIAN COMMUNITY SKIPPYCOIN IS NOT ACTIVE YET</h3><h4>if you are participating in the testing, go ahead and enter your wallet address</h4>
		<h4>If not, Skippycoin is coming to the 1000+ Town and City Websites of this network soon. You can follow Skippycoin progress at <a href="http://skippycoin.com" target="_blank" rel="nofollow">skippycoin.com</a> and we will no doubt let you know all about it simply by being a member here. The General plan is that we will distribute to YOU daily Australian Skippycoin and Business Accounts will receive the most.<br>Thank you for your support!</h4></font>
		';
		}
	?>
  <div align="center"><img src="/images/SKC-240.png" alt="Skippycoin" /></div>
  <div align="center">
    <h3>Imagine if we the people own our own coin</h3>
    One Skippycoin contains 1000 Roo and each Roo contains 1000 Joey.. That's how many Joey?<br />
    <hr />
    Skippycoin is the Community Crypto Coin of the Australian Regional Network and distributed throughout more than one thousand Australian Town and City websites. You can register for your share of Free coin and download your wallet at the <a href="http://skippybook.com" target="_blank" rel="nofollow">Skippybook</a><br />
    <br />
  </div>
</div>
@if($status != "")
<div class="row">
  <div class="col-sm-12">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <ul>
        <li><strong>{{ $status }}</strong></li>
      </ul>
    </div>
  </div>
</div>
@endif
<div class="row">
  <div class="col-sm-1">&nbsp;</div>
  <div class="col-sm-10"> {!! Form::open(['route' => 'save.skippywallet', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
    <div class="form-group">
      <center>
        Enter your valid Skippywallet Address here.
        <div class="input-group"> {{ Form::text('customer_skcwallet', null, ['class' => 'form-control', 'id' => 'search-input', 'placeholder' => 'Accuratley Enter 26 to 34 characters']) }} <span class="input-group-btn">
          <button class="btn btn-success" id="search" type="submit"><i class="fa fa-save"></i> Save</button>
          </span> </div>
      </center>
    </div>
    {!! Form::close() !!} </div>
  <div class="col-sm-1">&nbsp;</div>
</div>
@endif