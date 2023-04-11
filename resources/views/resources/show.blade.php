@extends('resources.layouts.base')

@section('title', 'GroupeZ')

@section('resource')
    <ul class="nav text-muted">
        <li><span>Version de Minecraft testées:</span> <span>1.7, 1.8, 1.9, 1.10, 1.11, 1.12, 1.13, 1.14, 1.15, 1.16, 1.17, 1.18, 1.19</span>
        </li>
        <li><span>Langues supportées:</span> <span>Français, English, Italiano, Español, Deutsch</span>
        </li>
    </ul>

    <div class="pt-3 mb-0 resource-content">
        {!! $resource->toHTML() !!}
    </div>

@endsection
