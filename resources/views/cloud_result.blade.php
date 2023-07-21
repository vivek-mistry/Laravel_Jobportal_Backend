<html>

<head>
    <title>Cloud Result</title>
    <style>
        html,
        body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        ul.cloud {
            list-style: none;
            padding-left: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            line-height: 2.75rem;
            width: 450px;
        }

        ul.cloud a {

            --size: 4;
            --color: #a33;
            color: var(--color);
            font-size: calc(var(--size) * 0.25rem + 0.5rem);
            display: block;
            padding: 0.125rem 0.25rem;
            position: relative;
            text-decoration: none;

        }

        ul.cloud a[data-weight="1"] {
            --size: 1;
        }

        ul.cloud a[data-weight="2"] {
            --size: 2;
        }

        ul.cloud a[data-weight="3"] {
            --size: 3;
        }

        ul.cloud a[data-weight="4"] {
            --size: 4;
        }

        ul.cloud a[data-weight="5"] {
            --size: 5;
        }

        ul.cloud a[data-weight="6"] {
            --size: 6;
        }

        /*ul.cloud a[data-weight="2"] {
            --size: 2;
        }

        ul.cloud a[data-weight="3"] {
            --size: 3;
        }

        ul.cloud a[data-weight="4"] {
            --size: 4;
        }

        ul.cloud a[data-weight="5"] {
            --size: 6;
        }

        ul.cloud a[data-weight="6"] {
            --size: 8;
        }

        ul.cloud a[data-weight="7"] {
            --size: 10;
        }

        ul.cloud a[data-weight="8"] {
            --size: 11;
        }

        ul.cloud a[data-weight="9"] {
            --size: 12;
        }*/

        ul[data-show-value] a::after {
            content: " ("attr(data-weight) ")";
            font-size: 1rem;
        }

        ul.cloud li:nth-child(2n+1) a {
            --color: #181;
        }

        ul.cloud li:nth-child(3n+1) a {
            --color: #33a;
        }

        ul.cloud li:nth-child(4n+1) a {
            --color: #c38;
        }

        ul.cloud a:focus {
            outline: 1px dashed;
        }

        ul.cloud a::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            width: 0;
            height: 100%;
            background: var(--color);
            transform: translate(-50%, 0);
            opacity: 0.15;
            transition: width 0.25s;
        }

        ul.cloud a:focus::before,
        ul.cloud a:hover::before {
            width: 100%;
        }

        @media (prefers-reduced-motion) {
            ul.cloud * {
                transition: none !important;
            }
        }
        /*body {

            position: absolute;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;

            display: grid;
            justify-content: center;
            align-content: center;
            gap: 5px;
        }

        body > div {
            color: #022f40;
        }

        body :nth-child(2n) {
            font-size: 2rem;
            color: #38aecc;
            font-weight: bold;
        }

        body :nth-child(3n) {
            writing-mode: vertical-lr;
            -webkit-writing-mode: vertical-lr;
            -ms-writing-mode: vertical-lr;
            color: #0090c1;
        }

        body :nth-child(4n) {
            font-size: 3rem;
            color: #183446;
        }

        body :nth-child(5n) {
            font-size: 4rem;
            color: #046e8f;
        }


        body{
            grid-template: '{{ $skill_string }}';
        }*/
    </style>
</head>

<body>
    <div style="padding: 10px">
    @php

    @endphp
    <ul class="cloud" role="navigation" aria-label="Webdev word cloud">
        @foreach ($result as $r)
            <li><a href="#" data-weight="{{ rand(0,9) }}">{{ $r['skill'] }}</a></li>
        @endforeach

    </ul>
    </div>
    @php
        /*
    @endphp
    @foreach ($result as $key => $r)
        <div id="{{ $key }}"> {{ $r['skill'] }}</div>
    @endforeach
    @php
        */
    @endphp
</body>

</html>
