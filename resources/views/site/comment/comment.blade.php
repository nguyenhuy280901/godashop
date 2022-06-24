<hr>
<span class="date pull-right">{{ $comment->created_date }}</span>
@php
    $customer = $comment->customer;
@endphp
<span class="by">{{ $customer->name }} ({{ $customer->email }})</span>
<input class="answered-rating-input" name="rating" type="text" title="" value="{{ $comment->star }}" readonly/>
<p>{{ $comment->description }}</p>