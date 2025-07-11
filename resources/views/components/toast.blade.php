@php
if (str_starts_with(request()->path(), 'cms')) {
$isRtl = 0;
}
@endphp
{{-- Global Toasts --}}
@if (session('success') || session('error') || $errors->any() || session('info') || session('warning'))
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
  @if (session('success'))
  <div class="toast success-toast show border-0 p-0 {{ $isRtl ? 'rtl-container' : 'not-rtl' }}" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="custom-toast-card bg-white p-2">
      <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
          fill="#04e4003a" fill-opacity="1"></path>
      </svg>

      <div class="icon-container"><i class="fa-regular fa-circle-check text-success"></i></div>
      <div class="message-text-container">
        <p class="message-text">Success!</p>
        <p class="sub-text">{{ session('success') }}</p>
      </div>
      <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  @endif

  @if (session('error') || $errors->any())
  <div class="toast error-toast show border-0 p-0 {{ $isRtl ? 'rtl-container' : '' }}" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="custom-toast-card bg-white p-2" style="--toast-color: #dc3545; --toast-bg: #dc354533;">
      <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
          fill="var(--toast-bg)" fill-opacity="1"></path>
      </svg>

      <div class="icon-container" style="background-color: var(--toast-bg);">
        <i class="fas fa-circle-xmark text-danger"></i>
      </div>
      <div class="message-text-container">
        <p class="message-text" style="color: var(--toast-color);">Oh no!</p>
        <p class="sub-text">
          @if (session('error'))
          {{ session('error') }}
          @elseif ($errors->any())
          {{ $errors->first() }}
          @endif
        </p>
      </div>
      <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  @endif
  @if (session('info'))
  <div class="toast info-toast show border-0 p-0 {{ $isRtl ? 'rtl-container' : '' }}" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="custom-toast-card bg-white p-2" style="--toast-color: #0d6efd; --toast-bg: #0d6efd33;">
      <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
          fill="var(--toast-bg)" fill-opacity="1"></path>
      </svg>

      <div class="icon-container" style="background-color: var(--toast-bg);">
        <i class="fas fa-info-circle" style="color: var(--toast-color);"></i>
      </div>
      <div class="message-text-container">
        <p class="message-text" style="color: var(--toast-color);">Info</p>
        <p class="sub-text">{{ session('info') }}</p>
      </div>
      <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  @endif
</div>
@endif
<style>
  .custom-toast-card {
    width: auto;
    height: fit-content;
    border-radius: 8px;
    box-sizing: border-box;
    background-color: #ffffff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 15px;
  }

  .custom-toast-card .wave {
    position: absolute;
    transform: rotate(90deg);
    left: -31px;
    top: 32px;
    width: 80px;
  }

  .custom-toast-card .icon-container {
    width: fit-content !important;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #04e40048;
    border-radius: 50% !important;
    margin-left: 8px;
    font-size: 18px;
  }

  .error-toast .custom-toast-card .icon-container {
    width: 2.5rem !important;
  }

  .custom-toast-card .message-text-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    flex-grow: 1;
  }

  .custom-toast-card .message-text,
  .custom-toast-card .sub-text {
    margin: 0;
    cursor: default;
  }

  .custom-toast-card .message-text {
    color: #269b24;
    font-size: 17px;
    font-weight: 700;
  }

  .info-toast .custom-toast-card .custom-toast-card .sub-text {
    font-size: 14px;
    color: #555;
  }
</style>