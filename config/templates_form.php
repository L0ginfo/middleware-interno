<?php

$config = [
    'Templates' => [
        'index' => [
            'input' => '<input {{attrs}} class="form-control {{class}}" type="{{type}}" name="{{name}}" >{{content}}</input>',
            'select' => '<select {{attrs}} class="form-control {{class}}" name="{{name}}" >{{content}}</select>',
            'label' => false
        ],
        'form' => [
            'input' => '<input class="form-control {{class}}" type="{{type}}" name="{{name}}" {{attrs}}>{{content}}</input>',
            'select' => '<select class="form-control {{class}}" name="{{name}}" {{attrs}}>{{content}}</select>',
            'selectMultiple' => '<select class="form-control {{class}}" multiple="true" name="{{name}}" {{attrs}}>{{content}}</select>',
            'inputContainer' => '<div class="form-group">{{content}}</div>',
            'legend' => false,
            //'dateWidget' => '<div class="clearfix"></div><div class="pull-left dateformat">{{day}}</div><div class="pull-left dateformat">{{month}}</div><div class="pull-left dateformat">{{year}}</div><div class="clearfix"></div>',
            'textarea' => '<textarea class="form-control {{class}}" name="{{name}}">{{value}}</textarea>',
        ]
    ]
];
