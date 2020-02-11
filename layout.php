<html>
<head>
    <title>Layout</title>
    <style>

        /* */
        /* Hard coded Elements: */
        /* */

        * {
            color: #fefefe;
        }

        body, .wrapper {
            padding: 0;
            margin: 0;
            position: relative;
        }

        .wrap_cm {
            /* This Class can center the content with a mix-width */
            width: 900px;
            margin: 0 auto;
        }

        .block_line {
            float: left;
        }

        .clear {
            clear: both;
        }

        .row {
            display: flex;
            flex-direction: row;
        }

        .row-1 {
            order: 1;
            flex-grow: 1;
            display: inline-block;
        }

        .row-2 {
            order: 2;
            flex-grow: 1;
            display: inline-block;
        }

        .row-3 {
            order: 3;
            flex-grow: 1;
            display: inline-block;
        }

        .row-2-big {
            order: 2;
            flex-grow: 4;
            display: inline-block;
        }

        #body_overlay {
            min-height: 100%;
        }

        /* Content Alignment */

        #wrap_top_widget, #wrap_foot_text, #wrap_foot_widget_b {
            text-align: center;
        }

        #wrap_top_search, #wrap_content_widget, #wrap_foot_widget_c {
            text-align: right;
        }


        /* */
        /* Elements for Customizer: */
        /* */


        /* Backgrounds */

        body {
            /* Full Page */
            background-color: #666;
        }

        #body_overlay {
            /* Full Page Overlay */
            background-color: #222222;

        }

        #sec_head {
            /* Full Head */
        }

        #sec_head_meta {
            /* Full Head Meta */
            background-color: #757575;
        }

        #sec_head_content {
            /* Full Head Content */
        }

        #sec_head_nav {
            /* Full Head Nav */
            background-color: #757575;
        }

        #sec_content {
            /* Full Content */
        }

        #sec_foot {
            /* Full Footer */
        }

        #sec_foot_nav {
            /* Full Footer Nav */
            background-color: #757575;
        }

        #sec_foot_text {
            /* Full Footer Text */
            border-top: 1px solid #bcbcbc;
        }


        /* For Child Elements Style Adjustments */

        #wrap_top_nav {

        }

        #wrap_top_widget {

        }

        #wrap_top_search {

        }

        #wrap_head_content {

        }

        #wrap_head_nav {

        }

        #wrap_content_nav {

        }

        #wrap_content_output {

        }

        #wrap_content_widget {

        }

        #wrap_foot_nav {

        }

        .wrap_foot_widget {

        }

        #wrap_foot_widget_a {

        }

        #wrap_foot_widget_b {
        }

        #wrap_foot_widget_c {

        }

        #wrap_foot_text {

        }

    </style>
</head>
<body>
<div id="body_overlay" class="wrap wrapper">
    <div id="sec_head" class="wrapper">
        <div id="sec_head_meta" class="wrapper">
            <div class="wrap_cm wrapper row">
                <div id="wrap_top_nav" class="block_line row-1 wrapper">
                    Head Meta Nav
                </div>
                <div id="wrap_top_widget" class="block_line row-2 wrapper">
                    Head Meta Widget
                </div>
                <div id="wrap_top_search" class="block_line row-3 wrapper">
                    Head Meta Search
                </div>
            </div>
        </div>
        <div id="sec_head_content" class="clear wrapper">
            <div id="wrap_head_content" class="wrap_cm wrapper">
                Head Content
            </div>
        </div>
        <div id="sec_head_nav" class="wrapper">
            <div id="wrap_head_nav" class="wrap_cm wrapper">
                Head Nav
            </div>
        </div>
    </div>
    <div id="sec_content" class="wrapper">
        <div class="wrap_cm wrapper row">
            <div id="wrap_content_nav" class="block_line row-1 wrapper">
                Content Nav
            </div>
            <div id="wrap_content_output" class="block_line row-2-big wrapper">
                Content Ouput
            </div>
            <div id="wrap_content_widget" class="block_line row-3 wrapper">
                Content Widget
            </div>
        </div>
    </div>
    <div id="sec_foot" class="clear wrapper">
        <div id="sec_foot_nav" class="wrapper">
            <div id="wrap_foot_nav" class="wrap_cm wrapper">
                Foot Nav
            </div>
        </div>
        <div class="wrap_cm wrapper row">
            <div id="wrap_foot_widget_a" class="wrap_foot_widget block_line row-1 wrapper">
                Foot Widget A
            </div>
            <div id="wrap_foot_widget_b" class="wrap_foot_widget block_line row-2 wrapper">
                Foot Widget B
            </div>
            <div id="wrap_foot_widget_c" class="wrap_foot_widget block_line row-3 wrapper">
                Foot Widget C
            </div>
        </div>
        <div id="sec_foot_text" class="clear wrapper">
            <div id="wrap_foot_text" class="wrap_cm wrapper">
                Foot Text
            </div>
        </div>
    </div>
</div>
</body>
</html>