@extends('beautymail::templates.minty')

@section('content')

	@include('beautymail::templates.minty.contentStart')
		<tr>
			<td class="title">
				Dear,
			</td>
		</tr>
		<tr>
			<td width="100%" height="10"></td>
		</tr>
		<tr>
			<td class="paragraph">
				Congratulations! Your recent payment has been successfully accepted
			</td>
		</tr>
		<tr>
			<td width="100%" height="25">
				You can check your order details by clicking the following link
			</td>
		</tr>
		<tr>
			<td>
				@include('beautymail::templates.minty.button', ['text' => 'Order Details', 'link' => Protocol::home().'/account/payments'])
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
	@include('beautymail::templates.minty.contentEnd')

@stop