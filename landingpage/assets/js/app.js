$(function() {

	// Get the form.
	var form = $('#ajax-contact');
	
	// Get the messages div.
	var formMessages = $('#form-messages');

	// Set up an event listener for the contact form.
	$(form).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();
		console.log(formData);
		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');

			// Set the message text.
			$(formMessages).text(response);

			// Clear the form.
			$('#name').val('');
			$('#email').val('');
			$('#subject').val('');
			$('#message').val('');
		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});
});
$(document).ready(function($) {
        
	$("#register-form").validate({
	rules: {
		name: "required",                    
		email: {
			required: true,
			minlength: 6
		},
	 
	 
// 	},
// 	messages: {
// 		name: "Please enter your Name",                   
// 		email: {
// 			required: "Please enter your email address",
// 			Message: "Please enter your email address",
// 		},
// 	},
// 	 errorPlacement: function(error, element) 
// {
// if ( element.is(":radio") ) 
// {
// 	error.appendTo( element.parents('.form-group') );
// }
// else 
// { 
// 	error.insertAfter( element );
// }
// },
// 	submitHandler: function(form) {
// 		form.submit();
// 	}
	
// });
// });
// $(document).ready(function() {
// 	$("ajax-contact").validate({
// 	  rules: {
// 		name : {
// 		  required: true,
// 		  minlength: 3
// 		},
// 		email: {
// 		  required: true,
// 		  email: true
// 		},
// 		message:{
// 		  required: true,
// 		  minlength: 3
// 		}
// 	  },
// 	  messages : {
// 		name: {	
// 		  minlength: "Name should be at least 3 characters"
// 		},
	  
// 		email: {
// 		  email: "The email should be in the format: abc@domain.tld"
// 		},
// 		message: {
// 		  minlength: "Name should be at least 3 characters"
// 		  // required: "People with age over 50 have to enter their weight",
// 		  // number: "Please enter your weight as a numerical value"
// 		}
// 	  }
// 	});
//   });