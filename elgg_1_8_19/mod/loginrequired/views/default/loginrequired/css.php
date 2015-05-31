<?php
/**
 * Loginrequired Index CSS
 *
 */
?>

/*******************************
        Loginrequired Index
********************************/
.loginrequired-index {
        
}
.elgg-module-highlight {
        -webkit-box-shadow: 1px 1px 5px #CCC;
        -moz-box-shadow: 1px 1px 5px #CCC;
        box-shadow: 1px 1px 5px #CCC;
}
.elgg-module-highlight:hover {
        -webkit-box-shadow: 1px 1px 6px #AAA;
        -moz-box-shadow: 1px 1px 6px #AAA;
        box-shadow: 1px 1px 6px #AAA;
}

.loginrequired-index a {
	display: block;
	padding: 3px 0px;
	clear: both;
	font-weight: normal;
	line-height: 18px;
	color: #dd4814;
	white-space: nowrap;
	}
	
.loginrequired-index a:hover {
	text-decoration:none;
	color:#fff;
	background-color:#dd4814;
}

#myCarousel h1,#myCarousel h2,#myCarousel h3,#myCarousel h4,#myCarousel h5,#myCarousel h6 {
	color: #dd4814;
}


/* allow login window to be top page item for mobile devices */
#custom-home-login-form {
	float:right;
}

#custom-home-login-form .elgg-module .elgg-module {
 	margin-bottom:0;
 	background-color:#f3c2b0;
}

#custom-home-login-form h3 {
	display:none;
}

#custom-home-login-form h4 {
	font-size:20px;
	margin:12px 0;
}


#custom-home-login-form-inner {
	width:252px;
	margin: 0 auto;
}



#custom-home-login-form input[type='text']:focus , #custom-home-login-form input[type='password']:focus {
	border-color: rgba(221, 72, 20, 0.8);
	outline: 0;
	outline: thin dotted \9;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(221, 72, 20,.6);
	-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(221, 72, 20,.6);
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(221, 72, 20,.6);
}


#custom-home-login-form ul {
	list-style:none;
	padding:0;
	margin:12px 0 0 0;
	display:table;
	
    }

#custom-home-login-form ul li {
	padding-right:12px;
	display:table-cell;
}    
    
#custom-home-information {
	float:left;
}

@media (max-width: 979px) and (min-width: 768px) {
	#custom-home-login-form-inner {
		width:184px;
		margin: 0 auto;
	}

#custom-home-login-form input[type='text'] , #custom-home-login-form input[type='password'], #custom-home-login-form input[type='hidden'] {
		width:172px;
	}
}


@media (max-width: 767px) {
    #custom-home-login-form {
        display: inline-block;
        margin-top: 20px;
        width: 100%;
    }

    #custom-home-information {
        float:none !important;
    }
}


body > div > div.elgg-page-topbar.navbar.navbar-fixed-top > div > div > div.btn-group.pull-right > a {
display:none;
}

#myCarousel {
	border:1px solid #666;
	}



