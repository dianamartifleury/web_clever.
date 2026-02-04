<section>
    <header>
        <h2 class="section-title">
            {{ __('Delete Account') }}
        </h2>

        <p class="section-description">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Botón para mostrar el modal -->
    <button id="open-delete-modal" class="btn btn-danger">{{ __('Delete Account') }}</button>

    <!-- Modal -->
    <div id="delete-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}" class="form-container">
                @csrf
                @method('delete')

                <h3 class="section-title">{{ __('Are you sure you want to delete your account?') }}</h3>

                <p class="section-description">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="{{ __('Password') }}" />
                    @if ($errors->userDeletion->get('password'))
                        <p class="text-error">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="button-container">
                    <button type="button" id="close-delete-modal" class="btn btn-secondary">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Script para abrir/cerrar modal -->
<script>
    const openBtn = document.getElementById('open-delete-modal');
    const closeBtn = document.getElementById('close-delete-modal');
    const modal = document.getElementById('delete-modal');

    openBtn.addEventListener('click', () => modal.style.display = 'block');
    closeBtn.addEventListener('click', () => modal.style.display = 'none');

    // Cerrar al hacer click fuera del contenido
    window.addEventListener('click', (e) => {
        if(e.target === modal) modal.style.display = 'none';
    });
</script>
