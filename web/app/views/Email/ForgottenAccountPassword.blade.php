@include('Email.header')
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">
			<div class="content">
				<table>
					<tr>
						<td>
							<h3>Hi there,</h3>
							<p class="lead">Password Reset</p>
							<p class="callout">If you did not request a password change, then please contact us using the information below.</p>
							<p>A recent request to reset your password on Bristol 24/7 has prompted this email.</p>
							<p>If you experience any issues while registering please contact support, shown below in the contact panel.</p>
							<br/>
							<p>Here's your new account password: <strong>{{ $password }}</strong></p>
							<br/>
							<br/>							
							@include('Email.social')
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>
	</tr>
</table>
@include('Email.footer')