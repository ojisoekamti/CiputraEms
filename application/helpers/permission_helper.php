<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');


$thish =&get_instance();

$thish->load->database();
$level = $thish->db->select("*")->from("level")->get()->result();

$thish->load->library('session');
$group_id = $thish->session->group;
$permission = $thish->db->select("
                    menu.url,
                    sum(CAST(permission_menu.[read] AS INT)) as [read],
                    sum(CAST(permission_menu.[create] AS INT)) as [create],
                    sum(CAST(permission_menu.[update] AS INT)) as [update],
                    sum(CAST(permission_menu.[delete] AS INT)) as [delete]
                    ")
            ->from("group_user_level")
            ->join("permission_menu",
                    "permission_menu.level_id = group_user_level.level_id")
            ->join("menu",
                    "menu.id = permission_menu.menu_id")
            ->WHERE("group_user_id",$group_id)
            ->WHERE("'".current_url()."' like concat('%',url,'%')")
            ->group_by("menu.url")
            ->get()->row();

if(current_url() == site_url('dashboard') || current_url() == site_url()){
    // var_dump(site_url());
}else{

    // if($permission->read == 0){
    //     redirect(site_url('dashboard'));
    // }       
    // if(stripos(current_url(),"add") && $permission->create == 0){
    //     redirect(site_url('dashboard'));
    // }       
    // if(stripos(current_url(),"edit") && $permission->update == 0){
    //     redirect(site_url('dashboard'));
    // }       
    // if(stripos(current_url(),"delete") && $permission->delete == 0){
    //     redirect(site_url('dashboard'));
    // }     
}  

if ( ! function_exists('permission'))
{
	/**
	 * Base URL
	 *
	 * Create a local URL based on your basepath.
	 * Segments can be passed in as a string or an array, same as site_url
	 * or a URL to a file can be passed in, e.g. to an image file.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function permission()
	{
        $CI =& get_instance();
        $CI->load->library('session');
        $group_id = $CI->session->group;

		return $CI->db->select("
                                menu.url,
                                sum(CAST(permission_menu.[read] AS INT)) as [read],
                                sum(CAST(permission_menu.[create] AS INT)) as [create],
                                sum(CAST(permission_menu.[update] AS INT)) as [update],
                                sum(CAST(permission_menu.[delete] AS INT)) as [delete]
                                ")
                        ->from("group_user_level")
                        ->join("permission_menu",
                                "permission_menu.level_id = group_user_level.level_id")
                        ->join("menu",
                                "menu.id = permission_menu.menu_id")
                        ->WHERE("group_user_id",$group_id)
                        ->WHERE("'".current_url()."' like concat('%',url,'%')")
                        ->group_by("menu.url")
                        ->get()->row();
	}
}