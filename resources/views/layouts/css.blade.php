<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{isset($title)? $title : ''}}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link href="{{ asset('material') }}/css/custome.css" rel="stylesheet" />


    <style>
        .table-responsive {
            display: inline-table;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }

    
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            font-weight: bold;
        }

        .table thead tr th {
            font-size: 1.063rem;
            font-weight: 600;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #ffffff;
            background-color: #9c27b0;
            border-color: #9c27b0;
            border-radius: 50px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-radius: 50px;
            color: black;
            background-color: white;
            border-color: black;
        }

        .page-link {
            position: relative;
            display: block;
            border-radius: 50px;
            padding: 0.5rem 0.75rem;
            margin-left: 0;
            line-height: 1.25;
            color: #9c27b0;
            background-color: transparent;
            border: 0 solid #dee2e6;
        }
    </style>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"  />
	<style>
	table.dataTable {
    clear: both;
    margin-top: 6px !important;
    margin-bottom: 6px !important;
    max-width: none !important;
   border-collapse: collapse !important; 
}
	</style>
</head>

<body class="{{ $class ?? '' }}">