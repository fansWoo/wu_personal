<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//會員群組權限管理，紀錄每個groupid的會員能夠使用那些功能
$config['group_purview_Arr'] = array(
	'1' => array(//系統管理員，看得到所有系統及所有管理員
	),
	'2' => array(//總管理員，看得到除了系統管理員以外的所有管理員
		array('base', 'global', 'global', 'common'),
		array('base', 'global', 'global', 'email'),
		array('base', 'global', 'global', 'global_setting'),
// 		array('base', 'global', 'website_content', 'edit'),
// 		array('base', 'global', 'website_content', 'tablelist'),
// 		array('base', 'global', 'global_setting', 'edit'),
// 		array('base', 'global', 'global_setting', 'tablelist'),
// 		array('base', 'global', 'website_meta', 'seo'),
		array('base', 'global', 'website_meta', 'plugin'),
// 		array('base', 'advertising', 'advertising', 'edit'),
// 		array('base', 'advertising', 'advertising', 'tablelist'),
		// array('base', 'advertising', 'classmeta', 'edit'),
		// array('base', 'advertising', 'classmeta', 'tablelist'),
		array('base', 'pic', 'pic', 'edit'),
		array('base', 'pic', 'pic', 'tablelist'),
		array('base', 'pic', 'album', 'edit'),
		array('base', 'pic', 'album', 'tablelist'),
		array('base', 'pic', 'set', 'set'),
// 		array('base', 'file', 'file', 'edit'),
// 		array('base', 'file', 'file', 'tablelist'),
// 		array('base', 'file', 'classmeta', 'edit'),
// 		array('base', 'file', 'classmeta', 'tablelist'),
// 		array('base', 'file', 'set', 'set'),
		array('base', 'note', 'note', 'edit'),
		array('base', 'note', 'note', 'tablelist'),
		array('base', 'note', 'classmeta', 'edit'),
		array('base', 'note', 'classmeta', 'tablelist'),
		array('base', 'note', 'set', 'set'),
// 		array('base', 'comment', 'comment', 'edit'),
// 		array('base', 'comment', 'comment', 'tablelist'),
		// array('base', 'user', 'user', 'edit'),
		// array('base', 'user', 'user', 'tablelist'),
		array('base', 'user', 'user_shop', 'edit'),
		array('base', 'user', 'user_shop', 'tablelist'),
		// array('base', 'user', 'classmeta', 'edit'),
		// array('base', 'user', 'classmeta', 'tablelist'),
		array('base', 'user', 'set', 'set'),
		array('base', 'pager', 'pager', 'edit'),
		array('base', 'pager', 'pager', 'tablelist'),
		array('base', 'pager', 'classmeta', 'edit'),
		array('base', 'pager', 'classmeta', 'tablelist'),
		// array('base', 'pager', 'classmeta2', 'edit'),
		// array('base', 'pager', 'classmeta2', 'tablelist'),
		array('base', 'pager', 'set', 'set'),
		//array('base', 'showpiece', 'showpiece', 'edit'),
		//array('base', 'showpiece', 'showpiece', 'tablelist'),
		//array('base', 'showpiece', 'classmeta', 'edit'),
		//array('base', 'showpiece', 'classmeta', 'tablelist'),
		// array('base', 'showpiece', 'classmeta2', 'edit'),
		// array('base', 'showpiece', 'classmeta2', 'tablelist'),
		//array('base', 'showpiece', 'set', 'set'),
		//array('base', 'faq', 'faq', 'edit'),
		//array('base', 'faq', 'faq', 'tablelist'),
		//array('base', 'faq', 'classmeta', 'edit'),
		//array('base', 'faq', 'classmeta', 'tablelist'),
		array('base', 'contact', 'contact', 'edit'),
		array('base', 'contact', 'contact', 'tablelist'),
		array('base', 'contact', 'set', 'set'),

// 		array('shop', 'store', 'global', 'hot'),
// 		array('shop', 'store', 'global', 'tradein'),
// 		array('shop', 'store', 'global', 'coupon'),
// 		array('shop', 'store', 'global', 'transfer'),
// 		array('shop', 'transport', 'transport', 'edit'),
// 		array('shop', 'transport', 'transport', 'tablelist'),
// 		array('shop', 'product', 'product', 'edit'),
// 		array('shop', 'product', 'product', 'tablelist'),
// 		array('shop', 'product', 'classmeta', 'edit'),
// 		array('shop', 'product', 'classmeta', 'tablelist'),
// 		array('shop', 'product', 'classmeta2', 'edit'),
// 		array('shop', 'product', 'classmeta2', 'tablelist'),
// 		array('shop', 'product', 'set', 'set'),
// 		array('shop', 'order_shop', 'order_shop', 'edit'),
// 		array('shop', 'order_shop', 'order_shop', 'tablelist'),
// 		array('shop', 'order_shop', 'set', 'set'),
        
		// array('user', 'global', 'global', 'user'),
		array('user', 'global', 'global_shop', 'user'),
// 		array('user', 'order_shop', 'order_shop', 'edit'),
// 		array('user', 'order_shop', 'order_shop', 'tablelist')
	),
	'3' => array(//一般管理員，只看得到自己
		array('base', 'user', 'user_shop', 'edit'),
		array('base', 'user', 'user_shop', 'tablelist'),
		// array('base', 'user', 'classmeta', 'edit'),
		// array('base', 'user', 'classmeta', 'tablelist'),
        
		// array('user', 'global', 'global', 'user'),
		array('user', 'global', 'global_shop', 'user'),
		array('user', 'order_shop', 'order_shop', 'edit'),
		array('user', 'order_shop', 'order_shop', 'tablelist')
	),
	'100' => array(//一般會員
		array('base', 'note', 'note', 'edit'),
		array('base', 'note', 'note', 'tablelist'),
		array('base', 'note', 'classmeta', 'edit'),
		array('base', 'note', 'classmeta', 'tablelist'),
		array('base', 'pic', 'pic', 'edit'),
		array('base', 'pic', 'pic', 'tablelist'),
		array('base', 'pic', 'album', 'edit'),
		array('base', 'pic', 'album', 'tablelist'),
		array('base', 'comment', 'comment', 'edit'),
		array('base', 'comment', 'comment', 'tablelist'),
		
		// array('user', 'global', 'global', 'user'),
		array('user', 'global', 'global_shop', 'user'),
		array('user', 'order_shop', 'order_shop', 'edit'),
		array('user', 'order_shop', 'order_shop', 'tablelist')
	),
	'101' => array(//進階會員
		// array('user', 'global', 'global', 'user'),
		array('user', 'global', 'global_shop', 'user'),
		array('user', 'order_shop', 'order_shop', 'edit'),
		array('user', 'order_shop', 'order_shop', 'tablelist')
	)
);

//後台架構
$config['admin_sidebox'] = array(
		'base' => array(
			'title' => '基本管理',
			'child2' => array(
				'global' => array(
					'title' => '全域管理',
					'child3' => array(
						'global' => array(
							'title' => '全域',
							'child4' => array(
								'common' => array('title' => '網站總覽'),
                                'email' => array('title' => '郵件設置'),
                                'global_setting' => array('title' => '全域設置')
							)
						),
						'website_content' => [
							'title' => '網站內容',
							'child4' => [
								'edit' => [
									'title' => '編輯',
									'sidebar_hidden' => TRUE
								],
								'tablelist' => ['title' => '內容列表']
							]
						],
						'global_setting' => [
							'title' => '全域設置',
							'child4' => [
								'edit' => [
									'title' => '編輯',
									'sidebar_hidden' => TRUE
								],
								'tablelist' => ['title' => '設置列表']
							]
						],
						'website_meta' => [
							'title' => '網站標籤',
							'child4' => [
								'seo' => ['title' => 'SEO標籤'],
								'plugin' => ['title' => '第三方外掛']
							]
						]
					)
				),
				'advertising' => array(
					'title' => '廣告管理',
					'child3' => array(
						'advertising' => array(
							'title' => '廣告',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '廣告分類',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						)
					)
				),
				'note' => array(
					'title' => '文章管理',
					'child3' => array(
						'note' => array(
							'title' => '文章',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '分類標籤',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '文章系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'comment' => array(
					'title' => '留言管理',
					'child3' => array(
						'comment' => array(
							'title' => '留言',
							'child4' => array(
								'edit' => array('title' => '查看'),
								'tablelist' => array('title' => '列表')
							)
						)
					)
				),
				'pic' => array(
					'title' => '圖片管理',
					'child3' => array(
						'pic' => array(
							'title' => '圖片',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'album' => array(
							'title' => '分類標籤',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '圖片系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'file' => array(
					'title' => '檔案管理',
					'child3' => array(
						'file' => array(
							'title' => '檔案',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '分類標籤',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '檔案系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'showpiece' => array(
					'title' => '產品展示',
					'child3' => array(
						'showpiece' => array(
							'title' => '產品',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '產品分類',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta2' => array(
							'title' => '二級分類',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '產品系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'user' => array(
					'title' => '會員管理',
					'child3' => array(
						'user' => array(
							'title' => '會員',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'user_shop' => array(
							'title' => '會員',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '會員群組',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '會員系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'pager' => array(
				 	'title' => '動態頁面',
				 	'child3' => array(
				 		'pager' => array(
				 			'title' => '頁面',
				 			'child4' => array(
				 				'edit' => array('title' => '編輯'),
				 				'tablelist' => array('title' => '列表')
				 			)
				 		),
				 		'classmeta' => array(
				 			'title' => '頁籤分類',
				 			'child4' => array(
				 				'edit' => array('title' => '編輯'),
				 				'tablelist' => array('title' => '列表')
				 			)
				 		),
				 		'classmeta2' => array(
				 			'title' => '二級頁籤',
				 			'child4' => array(
				 				'edit' => array('title' => '編輯'),
				 				'tablelist' => array('title' => '列表')
				 			)
				 		),
				 		'set' => array(
							'title' => '動態頁面系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
				 	)
				 ),
				'faq' => array(
					'title' => '常見問題',
					'child3' => array(
						'faq' => array(
							'title' => '常見問題',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '分類標籤',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '常見問題系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'contact' => array(
				 	'title' => '聯繫單',
				 	'child3' => array(
				 		'contact' => array(
				 			'title' => '聯繫單',
				 			'child4' => array(
				 				'edit' => array('title' => '編輯'),
				 				'tablelist' => array('title' => '列表')
				 			)
				 		),
				 		'set' => array(
							'title' => '聯繫單系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
				 	)
				 )
			)
		),
		'shop' => array(
			'title' => '購物系統',
			'child2' => array(
				'store' => array(
					'title' => '商店設定',
					'child3' => array(
						'global' => array(
							'title' => '全域',
							'child4' => array(
								'hot' => array('title' => '熱銷商品'),
								'tradein' => array('title' => '滿額優惠'),
								'coupon' => array('title' => '折扣金規則'),
								'transfer' => array('title' => '轉帳帳號')
							)
						)
					)
				),
				'transport' => array(
					'title' => '運費管理',
					'child3' => array(
						'transport' => array(
							'title' => '運輸方式',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						)
					)
				),
				'product' => array(
					'title' => '銷售產品',
					'child3' => array(
						'product' => array(
							'title' => '產品',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta' => array(
							'title' => '產品分類',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'classmeta2' => array(
							'title' => '二級分類',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '產品系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				),
				'order_shop' => array(
					'title' => '訂單管理',
					'child3' => array(
						'order_shop' => array(
							'title' => '訂單',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						),
						'set' => array(
							'title' => '訂單系統',
							'child4' => array(
								'set' => array('title' => '設置')
							)
						)
					)
				)
			)
		),
		'user' => array(
			'title' => '帳號設定',
			'child2' => array(
				'global' => array(
					'title' => '帳號資料',
					'child3' => array(
						'global' => array(//本功能為一般網站時開啟
							'title' => '全域',
							'child4' => array(
								'user' => array('title' => '會員資料')
							)
						),
						'global_shop' => array(//本選項為購物網站時才開啟，具會員購物資料填寫功能
							'title' => '全域',
							'child4' => array(
								'user' => array('title' => '會員資料')
							)
						)
					)
				),
				'order_shop' => array(
					'title' => '我的訂單',
					'child3' => array(
						'order_shop' => array(
							'title' => '訂單',
							'child4' => array(
								'edit' => array('title' => '編輯'),
								'tablelist' => array('title' => '列表')
							)
						)
					)
				)
			)
		)
	);