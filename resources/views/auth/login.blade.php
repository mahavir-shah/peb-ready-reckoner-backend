@extends('layouts.app')
<style type="text/css">
    .active-btn{
        background-color: #24b183 !important;
        border-color: #24b183 !important;
    }
    #turn {
     display: none;
    }
     #turn p {
         font-size: 0;
    }
     @media screen and (min-width: 0) and (max-width: 812px) and (orientation: landscape) {
         #turn {
             display: block;
             position: fixed;
             width: 100vw;
             height: 100%;
             z-index: 9;
             top: 0;
             background-color: rgba(0, 0, 0, 0.9);
             color: white;
        }
         #turn p {
             color: white;
             position: absolute;
             top: 50%;
             left: 50%;
             transform: translate(-50%, -50%);
             text-align: center;
             font-size: 16px;
             font-family:  "Work Sans";
             font-weight: 400;
        }
         #turn p span {
             width: 100px;
             height: 100px;
             display: block;
             margin: auto;
             margin-bottom: 10px;
        }
         #turn p img {
             width: 100px;
             height: 100px;
        }
    }
 
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h4 class="mb-0">{{ __('Admin Login') }}</h4></div>
                <div class="card-body">
                     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="alert alert-danger d-none" id="login-error" role="alert">
                            {{ session('error') }}
                        </div>
                    <form id="login-form" method="post" action="{{ route('loginProcess') }}" >
                       @csrf 
                        <input type="hidden" id="recaptcha_token" name="recaptcha_token" value="">
                        <div class="row mb-3">
                            <label for="email" class="text-left col-md-5 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="text-left col-md-5 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary login_btn" disabled>
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="turn"><p><span><img src="https://hmmngbrd.nyc3.cdn.digitaloceanspaces.com/upload%2Flanding_page%2Fphone-rotate.png" alt=""></span>Please rotate your device to portrait<br>for better experience!</p></div>
@endsection

<script src="{{ asset('backend/js/jquery.js') }}"></script>
<script src="{{ asset('backend/js/jquery.validate.js') }}"></script>
<!--end::Page Scripts -->

<script type="text/javascript">

$(document).ready(function() {

   var validator = $('#login-form').validate({
        rules:{
            email: {
                required: true,
                email: true,
            },
            password:{
                required: true
            }
        },
        messages: {
            email: {
                required:"The email field is required",
                email:"Enter valid email address",
               // remote: "The entered email is invalid"
            },  
            password: {
                required:"The password field is required"
            }
        }
    });
     
    $(document).on('change','#email,#password',function() {
        if($('#login-form').valid() == 1){
            $('.login_btn').removeAttr('disabled');
            $('.login_btn').addClass('active-btn');
        }else{
            $('.login_btn').attr('disabled',true);
        }
    });
});
</script>
<script type="text/javascript">

    function enableBtn(){
        $('.login_btn').disabled = false;
        if($('#login-form').valid() == 1 ){
            $('.login_btn').removeAttr('disabled');
            $('.login_btn').addClass('active-btn');
         }
    }

</script>
