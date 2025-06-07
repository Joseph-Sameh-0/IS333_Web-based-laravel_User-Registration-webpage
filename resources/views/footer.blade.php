<footer style="background-color:#0A131A; padding: 40px 20px; margin-top: 40px; border-top: 1px solid #e7e7e7;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
        <!-- Registration Form -->
        <div>
            <h3 style="color: #FFFFFF; margin-bottom: 15px;">{{ __('registration_form.FORM') }}</h3>
        </div>

        <!-- Quick Links -->
        <div>

            <h3 style="color: #FFFFFF; margin-bottom: 15px;">{{ __('registration_form.LINKS') }}</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 8px;"><a href="#" style="color: #0376b8; text-decoration: none;">{{ __('registration_form.POLICY') }}</a></li>
                <li style="margin-bottom: 8px;"><a href="#" style="color: #0376b8; text-decoration: none;">{{ __('registration_form.SERVICE') }}</a></li>
                <li style="margin-bottom: 8px;"><a href="#" style="color: #0376b8; text-decoration: none;">{{ __('registration_form.CONTACTUS') }}</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h3 style="color: #FFFFFF; margin-bottom: 15px;">{{ __('registration_form.CONTACTUS') }}</h3>
            <p style="color: #FFFFFF; margin: 5px 0;">{{ __('registration_form.FOOTER_EMAIL') }}</p>
            <p style="color: #FFFFFF; margin: 5px 0;">{{ __('registration_form.FOOTER_PHONE') }}</p>
        </div>

        <!-- Social Media -->
        <div>
            <h3 style="color: #FFFFFF; margin-bottom: 15px;">{{ __('registration_form.FOLLOWUS') }}</h3>
            <div style="display: flex; gap: 12px;">
                <a href="#" style="display: flex; justify-content: center; align-items: center; width: 32px; height: 32px; background: #ddd; border-radius: 50%; text-decoration: none;">
                    <img src="{{ asset ('img/facebook.png')}}" alt="Facebook" style="width: 18px; height: 18px; object-fit: contain;">
                </a>
                <a href="#" style="display: flex; justify-content: center; align-items: center; width: 32px; height: 32px; background: #ddd; border-radius: 50%; text-decoration: none;">
                    <img src="{{ asset ('img/youtube.png')}}" alt="Youtube" style="width: 18px; height: 18px; object-fit: contain;">
                </a>
                <a href="#" style="display: flex; justify-content: center; align-items: center; width: 32px; height: 32px; background: #ddd; border-radius: 50%; text-decoration: none;">
                    <img src="{{ asset ('img/X.png')}}" alt="X" style="width: 18px; height: 18px; object-fit: contain;">
                </a>
                <a href="#" style="display: flex; justify-content: center; align-items: center; width: 32px; height: 32px; background: #ddd; border-radius: 50%; text-decoration: none;">
                    <img src="{{ asset ('img/linkedin.png')}}" alt="Linkedin" style="width: 18px; height: 18px; object-fit: contain;">
                </a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div style="text-align: center; padding-top: 20px; margin-top: 30px; border-top: 1px solid #e7e7e7; color: #FFFFFF; font-size: 14px;">
        <p>© {{date("Y")}} Neovate University. All rights reserved.</p>
    </div>
</footer>
