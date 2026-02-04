<section>
    <header>
        <h2 class="section-title">
            {{ __('Profile Information') }}
        </h2>

        <p class="section-description">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Formulario de reenvío de verificación -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulario principal -->
    <form method="post" action="{{ route('profile.update') }}" class="form-container">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-input" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if ($errors->get('name'))
                <p class="text-error">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-input" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if ($errors->get('email'))
                <p class="text-error">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="form-note">
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn-link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="button-container">
            <button type="submit" class="btn">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success" id="profile-saved">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
