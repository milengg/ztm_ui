<div id="lock" class="modal hidden">
  <div class="relative">
    <div class="fixed inset-0 z-40 bg-blue-dark bg-opacity-70"></div>
      <div class="modal fixed inset-0 flex items-center justify-center z-50">
        <div class="modal-content">
            <div class="bg-blue-block p-6 rounded-3xl">
                <form id="pin_form">
                    <div class="grid">
                        <p class="text-white text-center font-roboto text-xl">Моля, въведете пин за да отключите екрана</p>
                        <input type="password" id="pin_number" name="pin_number" class="bg-gray-50 focus:ring-teal-custom focus:border-teal-custom text-3xl text-center rounded my-10 p-1" required>
                        <div class="grid grid-cols-3 gap-3">
                            <input type="button" value="1" id="1" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="2" id="2" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="3" id="3" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="4" id="4" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="5" id="5" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="6" id="6" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="7" id="7" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="8" id="8" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="9" id="9" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="РЕСЕТ" id="clear" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl" onclick="document.getElementById('pin_number').value = '';"/>
                            <input type="button" value="0" id="0 " class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl pin-button"/>
                            <input type="button" value="ВЪВЕДИ" id="enter" class="bg-transparent hover:bg-teal-custom text-white font-semibold hover:text-white py-2 px-4 border border-teal-custom hover:border-transparent rounded-xl"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
  </div>
</div>
@push('js')
<script>
$(document).ready(function() {
  const pinNumber = $('#pin_number');
  const pinButtons = $('.pin-button');
  const pinForm = $('#pin_form');

  // Set initial focus on the pin_number input field
  pinNumber.focus();

  // Add event listeners to each pin button to update the input field value
  pinButtons.on('click', function() {
    pinNumber.val(pinNumber.val() + $(this).val());
    pinNumber.focus();
  });

  // Add event listener to the enter button to submit the form with AJAX
  const enterButton = $('#enter');
  enterButton.on('click', function(event) {
    event.preventDefault();
    $.ajax({
      url: '/auth/unlock',
      type: 'POST',
      data: pinForm.serialize(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        window.location = '/auth/main';
      },
      error: function(xhr, status, error) {
        alert("Грешен код, моля опитайте отново!");
      }
    });
  });
});
</script>
@endpush