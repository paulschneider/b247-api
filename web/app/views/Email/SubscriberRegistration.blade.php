@include('Email.header')
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">
				<div class="content">
					<table>
						<tr>
							<td>
								<h3>Welcome</h3>
								<p class="lead">Congratulations - you have now signed up for your new account on Bristol24/7</p>
								<p class="callout"> Your new password is: {{ $plainPassword }}</p>
								<p>Once you have logged in, you will be able to personalise your content and receive special offers and promotions based on your preferences.</p>
								<p>If you have any questions, please email <a href="emailto:support@b247.co.uk">support@b247.co.uk</a></p>
								<p></p>
								
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