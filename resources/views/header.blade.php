<!DOCTYPE html>
<html lang="en">
<header>
    <nav
        style="background-color: rgb(113, 172, 211); padding: 15px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; position: fixed; width: 100% ; top: 0;  box-sizing: border-box; z-index: 1000">
        <div style="display: flex; align-items: center; gap: 30px; margin: 0;">
            <a href="{{url('/')}}" style="display: flex; align-items: center; text-decoration: none; color: #FFFFFF;">
                <img src="{{asset ('/img/logo9.png') }}" alt="Logo"
                     style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover;">
            </a>
            <p style="margin: 0; color: #FFFFFF; font-size: 24px; white-space: nowrap;">Registration Form</p>
        </div>
        <div style="display: flex; align-items: center; flex-wrap: wrap; max-width: 70%; justify-content: flex-end;">
            @php($languages = ["ar" => "Arabic", "en" => "English"])
            <a href="{{route('lang.change', ['lang' => 'ar'])}}" style="margin: 5px 5px 5px 10px; color: #FFFFFF;">اللغة العربية</a>
            <div style="margin: 5px 0px; color:#FFFFFF;" >|</div>
            <a href="{{route('lang.change', ['lang' => 'en'])}}" style="margin: 5px 10px 5px 5px; color: #FFFFFF;">English</a>
            <a href="{{url('/')}}" style="margin: 5px 15px; color: #FFFFFF;">{{ __('registration_form.HOME') }}</a>
            <a href="#" style="margin: 5px 15px; color: #FFFFFF;">{{ __('registration_form.ABOUTUS') }}</a>
            <a href="#" style="margin: 5px 15px; color: #FFFFFF;">{{ __('registration_form.CONTACTUS') }}</a>
            <a href="{{url('/')}}" style="margin: 5px 15px; background-color: #0376b8; color: white; padding: 8px 15px; border-radius: 5px;">{{ __('registration_form.LOGIN') }}</a>
        </div>
    </nav>
</header>
