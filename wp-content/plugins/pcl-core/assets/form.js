( function () {
	'use strict';

	var form = document.querySelector( '.pcl-form' );

	if ( ! form || ! window.pclForm ) {
		return;
	}

	var status = form.querySelector( '.pcl-form-status' );
	var submit = form.querySelector( 'button[type="submit"]' );

	function setStatus( message, type ) {
		if ( ! status ) {
			return;
		}
		status.textContent = message;
		status.classList.remove( 'is-success', 'is-error' );
		if ( type ) {
			status.classList.add( 'is-' + type );
		}
	}

	function clearErrors() {
		form.querySelectorAll( '[aria-invalid="true"]' ).forEach( function ( field ) {
			field.removeAttribute( 'aria-invalid' );
		} );
		form.querySelectorAll( '.pcl-field-error' ).forEach( function ( el ) {
			el.parentNode.removeChild( el );
		} );
	}

	function markError( field, message ) {
		field.setAttribute( 'aria-invalid', 'true' );
		var hint = document.createElement( 'p' );
		hint.className = 'pcl-field-error';
		hint.textContent = message;
		field.parentNode.appendChild( hint );
	}

	form.addEventListener( 'submit', function ( event ) {
		event.preventDefault();

		clearErrors();

		var data = new FormData( form );
		var payload = {};
		data.forEach( function ( value, key ) {
			payload[ key ] = value;
		} );

		submit.setAttribute( 'disabled', 'disabled' );
		setStatus( '', '' );

		fetch( window.pclForm.restUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': window.pclForm.nonce
			},
			body: JSON.stringify( payload )
		} )
			.then( function ( response ) {
				return response.json().then( function ( body ) {
					return { ok: response.ok, status: response.status, body: body };
				} );
			} )
			.then( function ( result ) {
				if ( result.ok && result.body.success ) {
					setStatus( result.body.message, 'success' );
					form.reset();
					return;
				}

				setStatus( result.body.message || 'Something went wrong. Please try again.', 'error' );

				if ( result.body.fields ) {
					Object.keys( result.body.fields ).forEach( function ( key ) {
						var field = form.querySelector( '[name="' + key + '"]' );
						if ( field ) {
							markError( field, result.body.fields[ key ] );
						}
					} );
				}
			} )
			.catch( function () {
				setStatus( 'Unable to send the message. Please try again.', 'error' );
			} )
			.finally( function () {
				submit.removeAttribute( 'disabled' );
			} );
	} );
} )();
