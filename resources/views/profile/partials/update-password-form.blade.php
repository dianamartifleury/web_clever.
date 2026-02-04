<section>
    <header>
        <h2 class="section-title">
            {{ __('Update Password') }}
        </h2>

        <p class="section-description">
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="form-container">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-input" required autocomplete="current-password" />
            @if ($errors->get('current_password'))
                <p class="text-error">{{ $errors->first('current_password') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" class="form-input" required autocomplete="new-password" />
            @if ($errors->get('password'))
                <p class="text-error">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" required autocomplete="new-password" />
        </div>

        <div class="button-container">
            <button type="submit" class="btn">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-success" id="password-saved">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    // Ocultar mensajes "Saved." después de 2 segundos
    setTimeout(() => {
        const profileMsg = document.getElementById('profile-saved');
        if(profileMsg) profileMsg.style.display = 'none';
        const passwordMsg = document.getElementById('password-saved');
        if(passwordMsg) passwordMsg.style.display = 'none';
    }, 2000);
</script>
