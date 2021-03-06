<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection blank_name
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection mobile
     * @property Grid\Column|Collection qq
     * @property Grid\Column|Collection balance
     * @property Grid\Column|Collection commission
     * @property Grid\Column|Collection vip
     * @property Grid\Column|Collection shareCode
     * @property Grid\Column|Collection loginTime
     * @property Grid\Column|Collection business_id
     * @property Grid\Column|Collection account
     * @property Grid\Column|Collection account_name
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection img_url
     * @property Grid\Column|Collection admin
     * @property Grid\Column|Collection task_id
     * @property Grid\Column|Collection task_no
     * @property Grid\Column|Collection before_balance
     * @property Grid\Column|Collection before_commission
     * @property Grid\Column|Collection change_balance
     * @property Grid\Column|Collection change_commission
     * @property Grid\Column|Collection after_balance
     * @property Grid\Column|Collection after_commission
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection device
     * @property Grid\Column|Collection p_parent_id
     * @property Grid\Column|Collection score
     * @property Grid\Column|Collection lv
     * @property Grid\Column|Collection login_time
     * @property Grid\Column|Collection share_code
     * @property Grid\Column|Collection lowest_score
     * @property Grid\Column|Collection highest_score
     * @property Grid\Column|Collection day_order_count
     * @property Grid\Column|Collection member_id
     * @property Grid\Column|Collection startTime
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection verify
     * @property Grid\Column|Collection area
     * @property Grid\Column|Collection sex
     * @property Grid\Column|Collection age
     * @property Grid\Column|Collection undertake
     * @property Grid\Column|Collection annual_income
     * @property Grid\Column|Collection params
     * @property Grid\Column|Collection interval
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection key
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection blank_name(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection mobile(string $label = null)
     * @method Grid\Column|Collection qq(string $label = null)
     * @method Grid\Column|Collection balance(string $label = null)
     * @method Grid\Column|Collection commission(string $label = null)
     * @method Grid\Column|Collection vip(string $label = null)
     * @method Grid\Column|Collection shareCode(string $label = null)
     * @method Grid\Column|Collection loginTime(string $label = null)
     * @method Grid\Column|Collection business_id(string $label = null)
     * @method Grid\Column|Collection account(string $label = null)
     * @method Grid\Column|Collection account_name(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection img_url(string $label = null)
     * @method Grid\Column|Collection admin(string $label = null)
     * @method Grid\Column|Collection task_id(string $label = null)
     * @method Grid\Column|Collection task_no(string $label = null)
     * @method Grid\Column|Collection before_balance(string $label = null)
     * @method Grid\Column|Collection before_commission(string $label = null)
     * @method Grid\Column|Collection change_balance(string $label = null)
     * @method Grid\Column|Collection change_commission(string $label = null)
     * @method Grid\Column|Collection after_balance(string $label = null)
     * @method Grid\Column|Collection after_commission(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection device(string $label = null)
     * @method Grid\Column|Collection p_parent_id(string $label = null)
     * @method Grid\Column|Collection score(string $label = null)
     * @method Grid\Column|Collection lv(string $label = null)
     * @method Grid\Column|Collection login_time(string $label = null)
     * @method Grid\Column|Collection share_code(string $label = null)
     * @method Grid\Column|Collection lowest_score(string $label = null)
     * @method Grid\Column|Collection highest_score(string $label = null)
     * @method Grid\Column|Collection day_order_count(string $label = null)
     * @method Grid\Column|Collection member_id(string $label = null)
     * @method Grid\Column|Collection startTime(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection verify(string $label = null)
     * @method Grid\Column|Collection area(string $label = null)
     * @method Grid\Column|Collection sex(string $label = null)
     * @method Grid\Column|Collection age(string $label = null)
     * @method Grid\Column|Collection undertake(string $label = null)
     * @method Grid\Column|Collection annual_income(string $label = null)
     * @method Grid\Column|Collection params(string $label = null)
     * @method Grid\Column|Collection interval(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection key(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection content
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection blank_name
     * @property Show\Field|Collection status
     * @property Show\Field|Collection mobile
     * @property Show\Field|Collection qq
     * @property Show\Field|Collection balance
     * @property Show\Field|Collection commission
     * @property Show\Field|Collection vip
     * @property Show\Field|Collection shareCode
     * @property Show\Field|Collection loginTime
     * @property Show\Field|Collection business_id
     * @property Show\Field|Collection account
     * @property Show\Field|Collection account_name
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection img_url
     * @property Show\Field|Collection admin
     * @property Show\Field|Collection task_id
     * @property Show\Field|Collection task_no
     * @property Show\Field|Collection before_balance
     * @property Show\Field|Collection before_commission
     * @property Show\Field|Collection change_balance
     * @property Show\Field|Collection change_commission
     * @property Show\Field|Collection after_balance
     * @property Show\Field|Collection after_commission
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection device
     * @property Show\Field|Collection p_parent_id
     * @property Show\Field|Collection score
     * @property Show\Field|Collection lv
     * @property Show\Field|Collection login_time
     * @property Show\Field|Collection share_code
     * @property Show\Field|Collection lowest_score
     * @property Show\Field|Collection highest_score
     * @property Show\Field|Collection day_order_count
     * @property Show\Field|Collection member_id
     * @property Show\Field|Collection startTime
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection verify
     * @property Show\Field|Collection area
     * @property Show\Field|Collection sex
     * @property Show\Field|Collection age
     * @property Show\Field|Collection undertake
     * @property Show\Field|Collection annual_income
     * @property Show\Field|Collection params
     * @property Show\Field|Collection interval
     * @property Show\Field|Collection price
     * @property Show\Field|Collection key
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection blank_name(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection mobile(string $label = null)
     * @method Show\Field|Collection qq(string $label = null)
     * @method Show\Field|Collection balance(string $label = null)
     * @method Show\Field|Collection commission(string $label = null)
     * @method Show\Field|Collection vip(string $label = null)
     * @method Show\Field|Collection shareCode(string $label = null)
     * @method Show\Field|Collection loginTime(string $label = null)
     * @method Show\Field|Collection business_id(string $label = null)
     * @method Show\Field|Collection account(string $label = null)
     * @method Show\Field|Collection account_name(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection img_url(string $label = null)
     * @method Show\Field|Collection admin(string $label = null)
     * @method Show\Field|Collection task_id(string $label = null)
     * @method Show\Field|Collection task_no(string $label = null)
     * @method Show\Field|Collection before_balance(string $label = null)
     * @method Show\Field|Collection before_commission(string $label = null)
     * @method Show\Field|Collection change_balance(string $label = null)
     * @method Show\Field|Collection change_commission(string $label = null)
     * @method Show\Field|Collection after_balance(string $label = null)
     * @method Show\Field|Collection after_commission(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection device(string $label = null)
     * @method Show\Field|Collection p_parent_id(string $label = null)
     * @method Show\Field|Collection score(string $label = null)
     * @method Show\Field|Collection lv(string $label = null)
     * @method Show\Field|Collection login_time(string $label = null)
     * @method Show\Field|Collection share_code(string $label = null)
     * @method Show\Field|Collection lowest_score(string $label = null)
     * @method Show\Field|Collection highest_score(string $label = null)
     * @method Show\Field|Collection day_order_count(string $label = null)
     * @method Show\Field|Collection member_id(string $label = null)
     * @method Show\Field|Collection startTime(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection verify(string $label = null)
     * @method Show\Field|Collection area(string $label = null)
     * @method Show\Field|Collection sex(string $label = null)
     * @method Show\Field|Collection age(string $label = null)
     * @method Show\Field|Collection undertake(string $label = null)
     * @method Show\Field|Collection annual_income(string $label = null)
     * @method Show\Field|Collection params(string $label = null)
     * @method Show\Field|Collection interval(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection key(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
