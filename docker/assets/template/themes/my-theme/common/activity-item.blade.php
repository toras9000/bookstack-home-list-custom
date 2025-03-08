
{{--Requires an Activity item with the name $activity passed in--}}

<div>
    @if($activity->user)
    <img class="avatar" src="{{ $activity->user->getAvatar(30) }}" alt="{{ $activity->user->name }}">
    @endif
</div>

<div>
    @if($activity->user)
        <a href="{{ $activity->user->getProfileUrl() }}">{{ $activity->user->name }}</a>
    @else
        {{ trans('common.deleted_user') }}
    @endif

    {{ $activity->getText() }}

    @if($activity->loggable && is_null($activity->loggable->deleted_at))
        <a href="{{ $activity->loggable->getUrl() }}">{{ $activity->loggable->name }}</a>
    @endif

    @if($activity->loggable && !is_null($activity->loggable->deleted_at))
        "{{ $activity->loggable->name }}"
    @endif

    @if(!$activity->loggable)
        {{ $activity->detail }}
    @endif

    <div style="font-size: 9pt;">
        @if($activity->loggable && $context == 'home')
            @php
                if ($activity->loggable->isA('page')) $activity->loggable->loadMissing('book', 'chapter');
            @endphp
            @if($activity->loggable->relationLoaded('book') && $activity->loggable->book)
                <span class="text-book">{{ $activity->loggable->book->getShortName(42) }}</span>
                @if($activity->loggable->relationLoaded('chapter') && $activity->loggable->chapter)
                    <span class="text-muted entity-list-item-path-sep">@icon('chevron-right')</span> <span class="text-chapter">{{ $activity->loggable->chapter->getShortName(42) }}</span>
                @endif
            @endif
        @endif
    </div>

    <span class="text-muted"><small>@icon('time'){{ $activity->created_at->diffForHumans() }}</small></span>
</div>
