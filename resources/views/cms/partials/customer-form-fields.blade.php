{{-- First Name --}}
<div class="input-container mb-5 mt-3">
    <input type="text" name="first_name" placeholder="" required>
    <label class="label">First Name</label>
    <div class="underline"></div>
</div>

{{-- Last Name --}}
<div class="input-container mb-5">
    <input type="text" name="last_name" placeholder="" required>
    <label class="label">Last Name</label>
    <div class="underline"></div>
</div>

{{-- Date of Birth --}}
<div class="input-container mb-4">
    <input type="date" name="dob" placeholder="">
    <label class="label">Date of Birth</label>
    <div class="underline"></div>
</div>

{{-- Gender Toggle --}}
<div class="checkbox-wrapper-8 mb-5">
    <label for="gender" class="visible-label">Gender</label>
    <input type="hidden" name="gender" value="female">
    <input type="checkbox" id="gender" name="gender" class="tgl" value="male">
    <label for="gender" class="tgl-btn" data-tg-on="Male" data-tg-off="Female"></label>
</div>

{{-- Mobile --}}
<div class="input-container mb-5">
    <input type="text" name="mobile" placeholder="">
    <label class="label">Mobile</label>
    <div class="underline"></div>
</div>

{{-- Email --}}
<div class="input-container mb-5">
    <input type="email" name="email" placeholder="" required>
    <label class="label">Email</label>
    <div class="underline"></div>
</div>

{{-- Password --}}
<div class="input-container mb-3">
    <input type="text" name="password" placeholder="" required>
    <label class="label">Password</label>
    <div class="underline"></div>
</div>

{{-- Submit Buttons --}}
<div class="d-flex justify-content-end">
    <a href="{{ route('customers.index') }}" class="btn bubbles bubbles-grey me-2">
        <span class="text">Cancel</span>
    </a>
    <button type="submit" class="btn bubbles">
        <span class="text">Create</span>
    </button>
</div>