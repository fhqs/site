<!DOCTYPE html>
<html>
    <head>
        @include('head')
    </head>
    <body>
        <header class="row">
        @include('header')
        </header>
        <div class="container" id="container" role="main">

            <div id="main" class="row">
            	@if (session('socialerror'))
		        <div class="alert alert-danger">
            		{{session('socialerror')}}
		        </div>
            	@endif

            	@if (session('signuperror'))
		        <div class="alert alert-danger">
            		{{session('signuperror')}}
		        </div>
            	@endif

            	@if ($errors->has())
		        <div class="alert alert-danger">
		            @foreach ($errors->all() as $error)
		                {{ $error }}<br>        
		            @endforeach
		        </div>
		        @endif

                {!! Form::open(array('url' => 'signup')) !!}
				<h1>Login</h1>
				@if(Session::has('error'))
				<div class="alert-box success">
				  <h2>{!! Session::get('error') !!}</h2>
				</div>
				@endif
				<div class="controls">
				{!! Form::text('firstname', '',array('id'=>'','class'=>'form-control span6','placeholder' => 'Please Enter your Firstname', 'required'=>'required')) !!}
				<p class="errors">{{$errors->first('firstname')}}</p>
				</div>
				<div class="controls">
				{!! Form::text('lastname', '',array('id'=>'','class'=>'form-control span6','placeholder' => 'Please Enter your Lastname', 'required'=>'required')) !!}
				<p class="errors">{{$errors->first('lastname')}}</p>
				</div>
				<div class="controls">
					{!! Form::select('gender', [
					   'male' => 'male',
					   'female' => 'female'], 
					   null, ['class' => 'form-control'] 
					)!!}
					<p></p>
				</div>
				<div class="controls">
				{!! Form::text('email', '',array('id'=>'','class'=>'form-control span6','placeholder' => 'Please Enter your Email', 'required'=>'required')) !!}
				<p class="errors">{{$errors->first('email')}}</p>
				</div>
				<div class="controls">
				{!! Form::password('password',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password', 'required'=>'required')) !!}
				<p class="errors">{{$errors->first('password')}}</p>
				</div>
				<div class="controls">
				{!! Form::password('password_confirmation',array('class'=>'form-control span6', 'placeholder' => 'Please Confirm your Password', 'required'=>'required')) !!}
				<p class="errors">{{$errors->first('password')}}</p>
				</div>
				<p>{!! Form::submit('Signup', array('class'=>'btn btn-primary')) !!} &nbsp; &nbsp; or &nbsp; &nbsp; {!! Form::button('Login', array('class'=>'btn btn-default', 'id'=>'signinbtn')) !!}</p>
				<div class="controls">
					<a class="btn btn-block btn-social btn-facebook" href="facebook">
					    <span class="fa fa-facebook"></span> Sign up with Facebook account
		  			</a>
	  			</div>
	  			{!! Form::close() !!}
            </div>

            <footer class="row">
            @include('footer')
            </footer>
        </div>
    </body>
</html>
