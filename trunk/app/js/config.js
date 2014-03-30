'use strict';
var server_base_url = "http://localhost/out_project/xkld-site/service/index.php/";
var client_base_url = "http://localhost/out_project/xkld-site/app/";

// Declare app level module which depends on 
angular.module('config',[])

    .constant('TEMPLATES', {
       
    })
    
    
    .constant('SERVICE_URL', {
        get_list_posts: server_base_url + "post/list",
		get_top_five_order: server_base_url + "post/topfive",
		
		/*
			Order category
			4: Japanese
			5: Taiwan
			6: general info about exporting labor
		*/
		get_top_five_order_with_category: server_base_url + "post/topfive-order-with-category",
		get_all_orders_with_category: server_base_url + "post/orders-with-category",
		get_post_by_id: server_base_url + "post/post-by-id"
    });
   