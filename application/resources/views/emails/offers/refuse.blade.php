{{ Profile::full_name($offer->offer_to) }} Refused your offer {{ Helper::getPriceFormat($offer->price, Helper::ad_details($offer->ad_id, 'currency') }}

Contact the seller via phone

{{ Profile::phone($offer->offer_to) }}

{{ Protocol::home() }}/vi/{{ $offer->ad_id }}