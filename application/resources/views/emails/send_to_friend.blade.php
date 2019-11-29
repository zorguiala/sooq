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
				{{ $messageContent }}
			</td>
		</tr>
		<tr>
			<td>
				@include('beautymail::templates.minty.button', ['text' => 'See Ad', 'link' => $url])
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
	@include('beautymail::templates.minty.contentEnd')

@stop