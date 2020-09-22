@extends('layouts.front')
@section('title', 'Sharing Successful')
@section('content')
        <div id="success-container">
            <div class="alert alert-success" role="alert">
    		<strong>Congratulations!</strong> Your message was sent successfully.
	    </div>
            <br/><br/>
            <center><a href="{{ route('login') }}"><button type="button" class="btn btn-success"><< Back to login</button></a></center>
        </div>
@endsection
<style>
        #success-container { margin: 10px auto; width: 500px; background-color: #fff; padding: 20px; border: 1px solid #003399; }
</style>
