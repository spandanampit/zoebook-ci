<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Users Controller
 *
 * @category admin
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Users
 *
 * @class Users.php
 *
 * @path application\admin\user\controllers\Users.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.10.2021
 */

class Users extends Cit_Controller
{
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     * @created Vamsi Ippe | 10.09.2018
     * @modified Rohit Patidar | 01.10.2021
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('listing');
        $this->load->library('filter');
        $this->load->library('dropdown');
        $this->load->model('users_model');
        $this->folder_name = "user";
        $this->module_name = "users";
        $this->module_heading = $this->lang->line('USERS_USERS');
        $this->mod_enc_url = $this->general->getGeneralEncryptList($this->folder_name, $this->module_name);
        $this->mod_enc_mode = $this->general->getCustomEncryptMode(TRUE);
        $this->_request_params();
        $this->module_config = array(
            'module_name' => $this->module_name,
            'folder_name' => $this->folder_name,
            'mod_enc_url' => $this->mod_enc_url,
            'mod_enc_mode' => $this->mod_enc_mode,
            'delete' => "No",
            'xeditable' => "No",
            'top_detail' => "No",
            "multi_lingual" => "No",
            "print_layouts" => array(),
            "workflow_modes" => array(),
            "skip_validation" => false,
            "physical_data_remove" => "Yes",
            "list_record_callback" => "",
        );
        $this->dropdown_arr = array(
            "u_email_verified" => array(
                "type" => "enum",
                "default" => "No",
                "values" => array(
                    array(
                        'id' => '1',
                        'val' => $this->lang->line('USERS_YES')
                    ),
                    array(
                        'id' => '0',
                        'val' => $this->lang->line('USERS_NO')
                    )
                )
            ),
            "u_status" => array(
                "type" => "enum",
                "default" => "Yes",
                "values" => array(
                    array(
                        'id' => 'Active',
                        'val' => $this->lang->line('USERS_ACTIVE')
                    ),
                    array(
                        'id' => 'Inactive',
                        'val' => $this->lang->line('USERS_INACTIVE')
                    )
                )
            ),
            "u_gender" => array(
                "type" => "phpfn",
                "function" => "",
            ),
            "u_subscribe_email" => array(
                "type" => "enum",
                "default" => "Yes",
                "values" => array(
                    array(
                        'id' => 'Yes',
                        'val' => $this->lang->line('USERS_YES')
                    ),
                    array(
                        'id' => 'No',
                        'val' => $this->lang->line('USERS_NO')
                    )
                )
            ),
            "u_unsubscribe_reasons_id" => array(
                "type" => "phpfn",
                "function" => "",
            ),
            "u_notification_pref" => array(
                "type" => "enum",
                "default" => "No",
                "values" => array(
                    array(
                        'id' => '1',
                        'val' => $this->lang->line('USERS_YES')
                    ),
                    array(
                        'id' => '0',
                        'val' => $this->lang->line('USERS_NO')
                    )
                )
            ),
            "u_privacy" => array(
                "type" => "enum",
                "default" => "No",
                "values" => array(
                    array(
                        'id' => '1',
                        'val' => $this->lang->line('USERS_YES')
                    ),
                    array(
                        'id' => '0',
                        'val' => $this->lang->line('USERS_NO')
                    )
                )
            ),
            "u_device_type" => array(
                "type" => "enum",
                "default" => "Yes",
                "values" => array(
                    array(
                        'id' => 'iOS',
                        'val' => $this->lang->line('USERS_IOS')
                    ),
                    array(
                        'id' => 'Android',
                        'val' => $this->lang->line('USERS_ANDROID')
                    )
                )
            )
        );
        $this->parMod = $this->params_arr["parMod"];
        $this->parID = $this->params_arr["parID"];
        $this->parRefer = array();
        $this->expRefer = array();

        $this->topRefer = array();
        $this->dropdown_limit = $this->config->item('ADMIN_DROPDOWN_LIMIT');
        $this->search_combo_limit = $this->config->item('ADMIN_SEARCH_COMBO_LIMIT');
        $this->switchto_limit = $this->config->item('ADMIN_SWITCH_DROPDOWN_LIMIT');
        $this->response_arr = array();
        $this->count_arr = array();
    }

    /**
     * _request_params method is used to set post/get/request params.
     */
    public function _request_params()
    {
        $this->get_arr = is_array($this->input->get(NULL, TRUE)) ? $this->input->get(NULL, TRUE) : array();
        $this->post_arr = is_array($this->input->post(NULL, TRUE)) ? $this->input->post(NULL, TRUE) : array();
        $this->params_arr = array_merge($this->get_arr, $this->post_arr);
        return $this->params_arr;
    }

    /**
     * index method is used to intialize grid listing page.
     */
    public function index()
    {
        $params_arr = $this->params_arr;
        $extra_qstr = $extra_hstr = '';
        try
        {
            if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
            {
                $access_list = array(
                    "users_list",
                    "users_view",
                    "users_add",
                    "users_update",
                    "users_delete",
                    "users_export",
                    "users_print",
                );
                list($list_access, $view_access, $add_access, $edit_access, $del_access, $expo_access, $print_access) = $this->filter->checkAccessCapability($access_list, TRUE);
            }
            else
            {
                $access_list = array(
                    "List",
                    "View",
                    "Add",
                    "Update",
                    "Delete",
                    "Export",
                    "Print",
                );
                list($list_access, $view_access, $add_access, $edit_access, $del_access, $expo_access, $print_access) = $this->filter->getModuleWiseAccess("users", $access_list, TRUE, TRUE);
            }
            if (!$list_access)
            {
                throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_VIEW_THIS_PAGE_C46_C46_C33'));
            }
            $enc_loc_module = $this->general->getMD5EncryptString("ListPrefer", "users");

            $status_array = array(
                'Active',
                'Inactive',
            );
            $status_label = array(
                'js_lang_label.USERS_ACTIVE',
                'js_lang_label.USERS_INACTIVE',
            );

            $list_config = $this->users_model->getListConfiguration();
            $this->processConfiguration($list_config, $add_access, $edit_access, TRUE);
            $this->general->trackModuleNavigation("Module", "List", "Viewed", $this->mod_enc_url["index"], "users");
            if (method_exists($this->filter, "setListFieldCapability"))
            {
                $this->filter->setListFieldCapability($list_config);
            }

            $extra_qstr .= $this->general->getRequestURLParams();
            $extra_hstr .= $this->general->getRequestHASHParams();
            $render_arr = array(

                'list_config' => $list_config,
                'count_arr' => $this->count_arr,
                'enc_loc_module' => $enc_loc_module,
                'status_array' => $status_array,
                'status_label' => $status_label,
                'view_access' => $view_access,
                'add_access' => $add_access,
                'edit_access' => $edit_access,
                'del_access' => $del_access,
                'expo_access' => $expo_access,
                'print_access' => $print_access,
                'folder_name' => $this->folder_name,
                'module_name' => $this->module_name,
                'module_heading' => $this->module_heading,
                'mod_enc_url' => $this->mod_enc_url,
                'mod_enc_mode' => $this->mod_enc_mode,
                'extra_qstr' => $extra_qstr,
                'extra_hstr' => $extra_hstr,
                "capabilities" => array(
                    "hide_multi_select" => "No",
                    "subgrid" => "No",
                ),
                'default_filters' => $this->users_model->default_filters,
            );
            $this->smarty->assign($render_arr);
            if (!empty($render_arr['overwrite_view']))
            {
                $this->loadView($render_arr['overwrite_view']);
            }
            else
            {
                $this->loadView("users_index");
            }
        }
        catch(Exception $e)
        {
            $render_arr['err_message'] = $e->getMessage();
            $this->smarty->assign($render_arr);
            $this->loadView($this->config->item('ADMIN_FORBIDDEN_TEMPLATE'));
        }
    }

    /**
     * listing method is used to load listing data records in json format.
     */
    public function listing()
    {
        $params_arr = $this->params_arr;
        $page = $params_arr['page'];
        $rows = $params_arr['rows'];
        $sidx = $params_arr['sidx'];
        $sord = $params_arr['sord'];
        $sdef = $params_arr['sdef'];
        $filters = $params_arr['filters'];
        if (!trim($sidx) && !trim($sord))
        {
            $sdef = 'Yes';
        }
        $filters = json_decode($filters, TRUE);
        $list_config = $this->users_model->getListConfiguration();
        $form_config = $this->users_model->getFormConfiguration();
        $extra_cond = $this->users_model->extra_cond;
        $groupby_cond = $this->users_model->groupby_cond;
        $having_cond = $this->users_model->having_cond;
        $orderby_cond = $this->users_model->orderby_cond;

        $data_config = array();
        $data_config['page'] = $page;
        $data_config['rows'] = $rows;
        $data_config['sidx'] = $sidx;
        $data_config['sord'] = $sord;
        $data_config['sdef'] = $sdef;
        $data_config['filters'] = $filters;
        $data_config['module_config'] = $this->module_config;
        $data_config['list_config'] = $list_config;
        $data_config['form_config'] = $form_config;
        $data_config['dropdown_arr'] = $this->dropdown_arr;
        $data_config['extra_cond'] = $extra_cond;
        $data_config['group_by'] = $groupby_cond;
        $data_config['having_cond'] = $having_cond;
        $data_config['order_by'] = $orderby_cond;

        $data_recs = $this->users_model->getListingData($data_config);
        $data_recs['no_records_msg'] = $this->general->processMessageLabel('ACTION_NO_USERS_DATA_FOUND_C46_C46_C33');

        echo json_encode($data_recs);
        $this->skip_template_view();
    }

    /**
     * export method is used to export listing data records in csv or pdf formats.
     */
    public function export()
    {
        if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
        {
            $this->filter->checkAccessCapability("users_export");
        }
        else
        {
            $this->filter->getModuleWiseAccess("users", "Export", TRUE);
        }
        $params_arr = $this->params_arr;
        $page = $params_arr['page'];
        $rowlimit = $params_arr['rowlimit'];
        $sidx = $params_arr['sidx'];
        $sord = $params_arr['sord'];
        $sdef = $params_arr['sdef'];
        if (!trim($sidx) && !trim($sord))
        {
            $sdef = 'Yes';
        }
        $selected = $params_arr['selected'];
        $id = explode(",", $params_arr['id']);
        $export_type = $params_arr['export_type'];
        $export_mode = $params_arr['export_mode'];
        $filters = $params_arr['filters'];
        $filters = json_decode(base64_decode($filters), TRUE);
        $fields = json_decode(base64_decode($params_arr['fields']), TRUE);
        $list_config = $this->users_model->getListConfiguration();
        $form_config = $this->users_model->getFormConfiguration();
        $table_name = $this->users_model->table_name;
        $table_alias = $this->users_modeltable_alias;
        $primary_key = $this->users_model->primary_key;
        $extra_cond = $this->users_model->extra_cond;
        $groupby_cond = $this->users_model->groupby_cond;
        $having_cond = $this->users_model->having_cond;
        $orderby_cond = $this->users_model->orderby_cond;
        if (method_exists($this->filter, "setListFieldCapability"))
        {
            $this->filter->setListFieldCapability($list_config);
        }
        $export_config = array();
        if ($selected == "true")
        {
            $export_config['id'] = $id;
        }
        $export_config['page'] = $page;
        $export_config['rowlimit'] = $rowlimit;
        $export_config['sidx'] = $sidx;
        $export_config['sord'] = $sord;
        $export_config['sdef'] = $sdef;
        $export_config['filters'] = $filters;
        $export_config['export_mode'] = $export_mode;
        $export_config['module_config'] = $this->module_config;
        $export_config['list_config'] = $list_config;
        $export_config['form_config'] = $form_config;
        $export_config['dropdown_arr'] = $this->dropdown_arr;
        $export_config['table_name'] = $table_name;
        $export_config['table_alias'] = $table_alias;
        $export_config['primary_key'] = $primary_key;
        $export_config['extra_cond'] = $extra_cond;
        $export_config['group_by'] = $groupby_cond;
        $export_config['having_cond'] = $having_cond;
        $export_config['order_by'] = $orderby_cond;

        $db_recs = $this->users_model->getExportData($export_config);
        $db_recs = $this->listing->getDataForList($db_recs, $export_config, "GExport", array());
        if (!is_array($db_recs) || count($db_recs) == 0)
        {
            $this->session->set_flashdata('failure', $this->general->processMessageLabel('GENERIC_GRID_NO_RECORDS_TO_PROCESS'));
            redirect($this->config->item("admin_url")."#".$this->mod_enc_url['index'].$extra_hstr);
        }

        require_once ($this->config->item('third_party').'Csv_export.php');
        require_once ($this->config->item('third_party').'Pdf_export.php');

        $tot_fields_arr = array_keys($db_recs[0]);
        if ($export_mode == "all" && is_array($tot_fields_arr))
        {
            if (($pr_key = array_search($primary_key, $tot_fields_arr)) !== FALSE)
            {
                unset($tot_fields_arr[$pr_key]);
            }
            $fields = array();
            if ($this->config->item("DISABLE_LIST_EXPORT_ALL"))
            {
                foreach ((array) $list_config as $key => $val)
                {
                    if (isset($val['export']) && $val['export'] == "Yes")
                    {
                        if (isset($val['hidecm']))
                        {
                            if (in_array($val['hidecm'], array("condition", "capability", "permanent")) && $val['hidden'] == "Yes")
                            {
                                continue;
                            }
                            if ($val['hideme'] == "Yes")
                            {
                                continue;
                            }
                        }
                        $fields[] = $key;
                    }
                }
            }
            else
            {
                $fields = array_values($tot_fields_arr);
            }
        }

        $misc_info = array();
        $misc_info['fields'] = $fields;
        $misc_info['heading'] = $this->module_heading;
        $misc_info['filename'] = "users_records_".count($db_recs);
        $misc_info['pdf_unit'] = PDF_UNIT;
        $misc_info['pdf_page_format'] = PDF_PAGE_FORMAT;
        $misc_info['pdf_page_orientation'] = (!empty($params_arr['orientation'])) ? $params_arr['orientation'] : PDF_PAGE_ORIENTATION;
        $misc_info['pdf_content_before_table'] = '';
        $misc_info['pdf_content_after_table'] = '';
        $misc_info['pdf_header_style'] = '';

        $fields = $misc_info['fields'];
        $heading = $misc_info['heading'];
        $filename = $misc_info['filename'];
        $numberOfColumns = count($fields);

        $columns = $aligns = $widths = $data = array();
        //Table headers info
        for ($i = 0; $i < $numberOfColumns; $i++)
        {
            $size = 10;
            $position = '';
            if (array_key_exists($fields[$i], $list_config))
            {
                $label = $list_config[$fields[$i]]['label_lang'];
                $position = $list_config[$fields[$i]]['align'];
                $size = $list_config[$fields[$i]]['width'];
            }
            elseif (array_key_exists($fields[$i], $form_config))
            {
                $label = $form_config[$fields[$i]]['label_lang'];
            }
            else
            {
                $label = $fields[$i];
            }
            $columns[] = $label;
            $aligns[] = in_array($position, array('right', 'center')) ? $position : "left";
            $widths[] = $size;
        }
        if ($export_type == 'pdf')
        {
            $pdf_style = "TCPDF";
            //Table data info
            $db_rec_cnt = count($db_recs);
            for ($i = 0; $i < $db_rec_cnt; $i++)
            {
                foreach ((array) $db_recs[$i] as $key => $val)
                {
                    if (is_array($fields) && in_array($key, $fields))
                    {
                        $data[$i][$key] = $this->listing->dataForExportMode($val, "pdf", $pdf_style);
                    }
                }
            }

            $pdf = new PDF_Export($misc_info['pdf_page_orientation'], $misc_info['pdf_unit'], $misc_info['pdf_page_format'], TRUE, 'UTF-8', FALSE);
            if (method_exists($pdf, "setModule"))
            {
                $pdf->setModule("users");
            }
            if (method_exists($pdf, "setContent"))
            {
                $pdf->setContent($misc_info);
            }
            if (method_exists($pdf, "setController"))
            {
                $pdf->setController($this);
            }
            $pdf->initialize($heading);
            $pdf->writeGridTable($columns, $data, $widths, $aligns);
            $pdf->Output($filename.".pdf", 'D');
        }
        elseif ($export_type == 'csv' || $export_type == 'xls')
        {
            //Table data info
            $db_recs_cnt = count($db_recs);
            for ($i = 0; $i < $db_recs_cnt; $i++)
            {
                foreach ((array) $db_recs[$i] as $key => $val)
                {
                    if (is_array($fields) && in_array($key, $fields))
                    {
                        $data[$i][$key] = $this->listing->dataForExportMode($val, "csv");
                    }
                }
            }
            $export_array = array_merge(array($columns), $data);
            if (is_file($this->config->item('third_party').'Xls_export.php'))
            {
                require_once ($this->config->item('third_party').'Xls_export.php');
            }
            else
            {
                $export_type == "csv";
            }
            if ($export_type == "xls" && class_exists("XLS_Writer"))
            {
                $xls = new XLS_Writer($export_array);
                if (method_exists($xls, "setModule"))
                {
                    $xls->setModule("users");
                }
                if (method_exists($xls, "setContent"))
                {
                    $xls->setContent($misc_info);
                }
                if (method_exists($xls, "setController"))
                {
                    $xls->setController($this);
                }
                $xls->headers($filename);
                $xls->initialize($heading);
                $xls->output($columns, $data, $widths, $aligns);
            }
            else
            {
                $csv = new CSV_Writer($export_array);
                if (method_exists($csv, "setModule"))
                {
                    $csv->setModule("users");
                }
                if (method_exists($csv, "setContent"))
                {
                    $csv->setContent($misc_info);
                }
                if (method_exists($csv, "setController"))
                {
                    $csv->setController($this);
                }
                $csv->headers($filename);
                $csv->output($columns, $data, $widths, $aligns);
            }
        }
        $this->skip_template_view();
    }

    /**
     * add method is used to add or update data records.
     */
    public function add()
    {
        $params_arr = $this->params_arr;
        $extra_qstr = $extra_hstr = '';
        $hideCtrl = $params_arr['hideCtrl'];
        $showDetail = $params_arr['showDetail'];
        $mode = (in_array($params_arr['mode'], array("Update", "View"))) ? "Update" : "Add";
        $viewMode = ($params_arr['mode'] == "View") ? TRUE : FALSE;
        $id = $params_arr['id'];
        $enc_id = $this->general->getAdminEncodeURL($id);
        try
        {
            $extra_cond = $this->users_model->extra_cond;
            if ($mode == "Update")
            {
                if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
                {
                    $access_list = array(
                        "users_list",
                        "users_view",
                        "users_update",
                        "users_delete",
                        "users_print",
                    );
                    list($list_access, $view_access, $edit_access, $del_access, $print_access) = $this->filter->checkAccessCapability($access_list, TRUE);
                }
                else
                {
                    $access_list = array(
                        "List",
                        "View",
                        "Update",
                        "Delete",
                        "Print",
                    );
                    list($list_access, $view_access, $edit_access, $del_access, $print_access) = $this->filter->getModuleWiseAccess("users", $access_list, TRUE, TRUE);
                }
                if (!$edit_access && !$view_access)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_VIEW_THIS_PAGE_C46_C46_C33'));
                }
            }
            else
            {
                if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
                {
                    $access_list = array(
                        "users_list",
                        "users_add",
                    );
                    list($list_access, $add_access) = $this->filter->checkAccessCapability($access_list, TRUE);
                }
                else
                {
                    $access_list = array(
                        "List",
                        "Add",
                    );
                    list($list_access, $add_access) = $this->filter->getModuleWiseAccess("users", $access_list, TRUE, TRUE);
                }
                if (!$add_access)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_ADD_THESE_DETAILS_C46_C46_C33'));
                }
            }

            $data = $orgi = $func = $elem = array();
            if ($mode == 'Update')
            {
                $ctrl_flow = $this->ci_local->read($this->general->getMD5EncryptString("FlowEdit", "users"), $this->session->userdata('iAdminId'));
                $data_arr = $this->users_model->getData(intval($id));
                $data = $orgi = $data_arr[0];
                if ((!is_array($data) || count($data) == 0) && $params_arr['rmPopup'] != "true")
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_RECORDS_WHICH_YOU_ARE_TRYING_TO_ACCESS_ARE_NOT_AVAILABLE_C46_C46_C33'));
                }

                $switch_arr = $switch_combo = $switch_cit = array();
                if (isset($this->params_arr['switchIDs']) && $this->params_arr['switchIDs'] != "")
                {
                    $switchIDs = explode(",", $this->params_arr['switchIDs']);
                    $switchIDs[] = $id;
                    $switchEsc = implode(",", $this->general->escape_str($switchIDs));
                    $switchCond = $this->db->protect($this->users_model->table_alias.".".$this->users_model->primary_key)." IN (".$switchEsc.")";
                    if ($extra_cond != "")
                    {
                        $extra_cond = ' AND '.$switchCond;
                    }
                    else
                    {
                        $extra_cond = $switchCond;
                    }
                }
                $switch_arr = $this->users_model->getSwitchTo($extra_cond, "records", $this->switchto_limit);
                $switch_combo = $this->filter->makeArrayDropDown($switch_arr);
                $switch_cit = array();
                $switch_tot = $this->users_model->getSwitchTo($extra_cond, "count");
                if ($this->switchto_limit > 0 && $switch_tot > $this->switchto_limit)
                {
                    $switch_cit['param'] = "true";
                    $switch_cit['url'] = $this->mod_enc_url['get_self_switch_to'];
                    if (!array_key_exists($id, $switch_combo))
                    {
                        $extra_cond = $this->db->protect($this->users_model->table_alias.".".$this->users_model->primary_key)." = ".$this->db->escape($id);
                        $switch_cur = $this->users_model->getSwitchTo($extra_cond, "records", 1);
                        if (is_array($switch_cur) && count($switch_cur) > 0)
                        {
                            $switch_arr[] = $switch_cur[0];
                            $switch_combo[$switch_cur[0]['id']] = $switch_cur[0]['val'];
                        }
                    }
                }
                $recName = $switch_combo[$id];
                $switch_enc_combo = $this->filter->getSwitchEncryptRec($switch_combo, $switch_arr);
                $this->dropdown->combo("array", "vSwitchPage", $switch_enc_combo, $enc_id, FALSE, "key_value", $switch_arr);
                $next_prev_records = $this->filter->getNextPrevRecords($id, $switch_arr);

                $this->general->trackModuleNavigation("Module", "Form", "Viewed", $this->mod_enc_url["add"], "users", $recName);
            }
            else
            {
                $recName = '';
                $ctrl_flow = $this->ci_local->read($this->general->getMD5EncryptString("FlowAdd", "users"), $this->session->userdata('iAdminId'));
                $this->general->trackModuleNavigation("Module", "Form", "Viewed", $this->mod_enc_url["add"], "users");
            }

            $opt_arr = $img_html = $auto_arr = $config_arr = array();

            $form_config = $this->users_model->getFormConfiguration($config_arr);
            if (is_array($form_config) && count($form_config) > 0)
            {
                foreach ($form_config as $key => $val)
                {
                    if ($params_arr['rmPopup'] == "true" && $params_arr[$key] != "")
                    {
                        $data[$key] = $params_arr[$key];
                    }
                    elseif ($val["dfapply"] != "")
                    {
                        $val['default'] = (substr($val['default'], 0, 6) == "copy::") ? $orgi[substr($val['default'], 6)] : $val['default'];
                        if ($val["dfapply"] == "forceApply" || $val["entry_type"] == "Custom")
                        {
                            $data[$key] = $val['default'];
                        }
                        elseif ($val["dfapply"] == "addOnly")
                        {
                            if ($mode == "Add")
                            {
                                $data[$key] = $val['default'];
                            }
                        }
                        elseif ($val["dfapply"] == "everyUpdate")
                        {
                            if ($mode == "Update" && $params_arr['mode'] != 'View')
                            {
                                $data[$key] = $val['default'];
                            }
                        }
                        else
                        {
                            $data[$key] = (trim($data[$key]) != "") ? $data[$key] : $val['default'];
                        }
                    }
                    if ($val['encrypt'] == "Yes" && $mode == "Update")
                    {
                        $data[$key] = $this->general->decryptDataMethod($data[$key], $val["enctype"]);
                    }
                    if ($val['function'] != "")
                    {
                        $fnctype = $val['functype'];
                        $phpfunc = $val['function'];
                        $tmpdata = '';
                        if (substr($phpfunc, 0, 12) == 'controller::' && substr($phpfunc, 12) !== FALSE)
                        {
                            $phpfunc = substr($phpfunc, 12);
                            if (method_exists($this, $phpfunc))
                            {
                                $tmpdata = $this->$phpfunc($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                            }
                        }
                        elseif (substr($phpfunc, 0, 7) == 'model::' && substr($phpfunc, 7) !== FALSE)
                        {
                            $phpfunc = substr($phpfunc, 7);
                            if (method_exists($this->users_model, $phpfunc))
                            {
                                $tmpdata = $this->users_model->$phpfunc($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                            }
                        }
                        elseif (method_exists($this->general, $phpfunc))
                        {
                            $tmpdata = $this->general->$phpfunc($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                        }
                        if ($fnctype == "input")
                        {
                            $elem[$key] = $tmpdata;
                        }
                        elseif ($fnctype == "status")
                        {
                            $func[$key] = $tmpdata;
                        }
                        else
                        {
                            $data[$key] = $tmpdata;
                        }
                    }
                    if ($val['field_status'] != "")
                    {
                        $status_type = $val['field_status'];
                        $fd_callback = $val['field_callback'];
                        if ($status_type == "capability" && $fd_callback != "")
                        {
                            $func[$key] = $this->filter->getFormFieldCapability($key, $this->module_name, $mode);
                        }
                        elseif ($status_type == "function")
                        {
                            $fd_status = 0;
                            if (substr($fd_callback, 0, 12) == 'controller::' && substr($fd_callback, 12) !== FALSE)
                            {
                                $fd_callback = substr($fd_callback, 12);
                                if (method_exists($this, $fd_callback))
                                {
                                    $fd_status = $this->$fd_callback($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                                }
                            }
                            elseif (substr($fd_callback, 0, 7) == 'model::' && substr($fd_callback, 7) !== FALSE)
                            {
                                $fd_callback = substr($fd_callback, 7);
                                if (method_exists($this->users_model, $fd_callback))
                                {
                                    $fd_status = $this->users_model->$fd_callback($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                                }
                            }
                            elseif (method_exists($this->general, $fd_callback))
                            {
                                $fd_status = $this->general->$fd_callback($mode, $data[$key], $data, $id, $key, $key, $this->module_name);
                            }
                            $func[$key] = $fd_status;
                        }
                    }
                    $source_field = $val['name'];
                    $combo_config = $this->dropdown_arr[$source_field];
                    if (is_array($combo_config) && count($combo_config) > 0)
                    {
                        if ($combo_config['auto'] == "Yes")
                        {
                            $combo_count = $this->getSourceOptions($source_field, $mode, $id, $data, '', 'count');
                            if ($combo_count[0]['tot'] > $this->dropdown_limit)
                            {
                                $auto_arr[$source_field] = "Yes";
                            }
                        }
                        $combo_arr = $this->getSourceOptions($source_field, $mode, $id, $data);
                        $final_arr = $this->filter->makeArrayDropdown($combo_arr);
                        if ($combo_config['opt_group'] == "Yes")
                        {
                            $display_arr = $this->filter->makeOPTDropdown($combo_arr);
                        }
                        else
                        {
                            $display_arr = $final_arr;
                        }
                        $this->dropdown->combo("array", $source_field, $display_arr, $data[$key]);
                        $opt_arr[$source_field] = $final_arr;
                    }
                    if ($val['file_upload'] == 'Yes')
                    {
                        $del_file = ($edit_access && $viewMode != TRUE && $func[$key] != 2) ? TRUE : FALSE;
                        $val['htmlID'] = $val['name'];
                        $img_html[$key] = $this->listing->parseFormFile($data[$key], $id, $data, $val, $this->module_config, "Form", $del_file);
                    }
                }
            }
            if (method_exists($this->filter, "setFormFieldCapability"))
            {
                $this->filter->setFormFieldCapability($func, $this->module_name, $mode);
            }
            $extra_qstr .= $this->general->getRequestURLParams();
            $extra_hstr .= $this->general->getRequestHASHParams();

            /** access controls <<< **/
            $controls_allow = $prev_link_allow = $next_link_allow = $update_allow = $delete_allow = $backlink_allow = $switchto_allow = $discard_allow = $tabing_allow = TRUE;
            if ($mode == "Update")
            {
                if (!$del_access || $this->module_config["delete"] == "Yes")
                {
                    $delete_allow = FALSE;
                }
            }
            if (is_array($switch_combo) && count($switch_combo) > 0)
            {
                $prev_link_allow = ($next_prev_records['prev']['id'] != '') ? TRUE : FALSE;
                $next_link_allow = ($next_prev_records['next']['id'] != '') ? TRUE : FALSE;
            }
            else
            {
                $prev_link_allow = $next_link_allow = $switchto_allow = FALSE;
            }
            if (!$list_access)
            {
                $backlink_allow = $discard_allow = FALSE;
            }
            if ($hideCtrl == "true")
            {
                $controls_allow = $prev_link_allow = $next_link_allow = $delete_allow = $backlink_allow = $switchto_allow = $tabing_allow = FALSE;
                $ctrl_flow = "Stay";
            }
            $wf_mode_arr = $this->module_config["workflow_modes"];
            if (is_array($wf_mode_arr) && in_array($mode, $wf_mode_arr))
            {
                $controls_allow = FALSE;
                $ctrl_flow = "Stay";
            }
            /** access controls >>> **/
            $render_arr = array(

                "edit_access" => $edit_access,
                "print_access" => $print_access,
                'controls_allow' => $controls_allow,
                'prev_link_allow' => $prev_link_allow,
                'next_link_allow' => $next_link_allow,
                'update_allow' => $update_allow,
                'delete_allow' => $delete_allow,
                'backlink_allow' => $backlink_allow,
                'switchto_allow' => $switchto_allow,
                'discard_allow' => $discard_allow,
                'tabing_allow' => $tabing_allow,
                'enc_id' => $enc_id,
                'id' => $id,
                'mode' => $mode,
                'data' => $data,
                'func' => $func,
                'elem' => $elem,
                'recName' => $recName,
                "opt_arr" => $opt_arr,
                "img_html" => $img_html,
                "auto_arr" => $auto_arr,
                'ctrl_flow' => $ctrl_flow,
                'switch_cit' => $switch_cit,
                "switch_arr" => $switch_arr,
                'switch_combo' => $switch_combo,
                'next_prev_records' => $next_prev_records,
                "form_config" => $form_config,
                'folder_name' => $this->folder_name,
                'module_name' => $this->module_name,
                'mod_enc_url' => $this->mod_enc_url,
                'mod_enc_mode' => $this->mod_enc_mode,
                'extra_qstr' => $extra_qstr,
                'extra_hstr' => $extra_hstr,
                'capabilities' => array()
            );
            $this->smarty->assign($render_arr);
            if (!empty($render_arr['overwrite_view']))
            {
                $this->loadView($render_arr['overwrite_view']);
            }
            else
            {
                if ($mode == "Update")
                {
                    if ($edit_access && $viewMode != TRUE)
                    {
                        $this->loadView("users_add");
                    }
                    else
                    {
                        $this->loadView("users_add_view");
                    }
                }
                else
                {
                    $this->loadView("users_add");
                }
            }
        }
        catch(Exception $e)
        {
            $render_arr['err_message'] = $e->getMessage();
            $this->smarty->assign($render_arr);
            $this->loadView($this->config->item('ADMIN_FORBIDDEN_TEMPLATE'));
        }
    }

    /**
     * addAction method is used to save data, which is posted through form.
     */
    public function addAction()
    {
        $params_arr = $this->params_arr;
        $mode = ($params_arr['mode'] == "Update") ? "Update" : "Add";
        $id = $params_arr['id'];
        try
        {
            $ret_arr = array();
            if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
            {
                if ($mode == "Update")
                {
                    $add_edit_access = $this->filter->checkAccessCapability("users_update", TRUE);
                }
                else
                {
                    $add_edit_access = $this->filter->checkAccessCapability("users_add", TRUE);
                }
            }
            else
            {
                $add_edit_access = $this->filter->getModuleWiseAccess("users", $mode, TRUE, TRUE);
            }
            if (!$add_edit_access)
            {
                if ($mode == "Update")
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_MODIFY_THESE_DETAILS_C46_C46_C33'));
                }
                else
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_ADD_THESE_DETAILS_C46_C46_C33'));
                }
            }

            $form_config = $this->users_model->getFormConfiguration();
            $params_arr = $this->_request_params();

            $u_profile_image = $params_arr["u_profile_image"];
            $u_name = $params_arr["u_name"];
            $u_email = $params_arr["u_email"];
            $u_password = $params_arr["u_password"];
            $u_facebook_id = $params_arr["u_facebook_id"];
            $u_google_id = $params_arr["u_google_id"];
            $u_phone = $params_arr["u_phone"];
            $u_email_verified = $params_arr["u_email_verified"];
            $u_status = $params_arr["u_status"];
            $u_about_me = $params_arr["u_about_me"];
            $u_latitude = $params_arr["u_latitude"];
            $u_longtitude = $params_arr["u_longtitude"];
            $u_modified_date = $params_arr["u_modified_date"];
            $u_temp_password = $params_arr["u_temp_password"];
            $u_device_token = $params_arr["u_device_token"];
            $u_cover_photo = $params_arr["u_cover_photo"];
            $u_d_ob = $params_arr["u_d_ob"];
            $u_gender = $params_arr["u_gender"];
            $u_cover_ydimention = $params_arr["u_cover_ydimention"];
            $u_cover_video = $params_arr["u_cover_video"];
            $u_apple_id = $params_arr["u_apple_id"];
            $u_vp_update_date = $params_arr["u_vp_update_date"];
            $u_my_feed_update_date = $params_arr["u_my_feed_update_date"];
            $u_cv_height = $params_arr["u_cv_height"];
            $u_cv_width = $params_arr["u_cv_width"];
            $u_subscribe_email = $params_arr["u_subscribe_email"];
            $u_unsubscribe_reasons_id = $params_arr["u_unsubscribe_reasons_id"];
            $u_notification_pref = $params_arr["u_notification_pref"];
            $u_privacy = $params_arr["u_privacy"];
            $u_device_type = $params_arr["u_device_type"];
            $u_device_name = $params_arr["u_device_name"];
            $u_device_os = $params_arr["u_device_os"];
            $u_app_version = $params_arr["u_app_version"];
            $u_added_date = $params_arr["u_added_date"];
            $u_last_login = $params_arr["u_last_login"];

            $unique_arr = array();
            $unique_arr["vEmail"] = $u_email;

            $unique_exists = $this->users_model->checkRecordExists($this->users_model->unique_fields, $unique_arr, $id, $mode, $this->users_model->unique_type);
            if ($unique_exists)
            {
                $error_msg = $this->general->processMessageLabel('ACTION_RECORD_ALREADY_EXISTS_WITH_THESE_DETAILS_OF_EMAIL_C46_C46_C33');
                if ($error_msg == "")
                {
                    $error_msg = "Record already exists with these details of Email";
                }
                throw new Exception($error_msg);
            }
            $data = $save_data_arr = $file_data = array();
            $data["vProfileImage"] = $u_profile_image;
            $data["vName"] = $u_name;
            $data["vEmail"] = $u_email;
            $data["vPassword"] = $u_password;
            $data["vFacebookId"] = $u_facebook_id;
            $data["vGoogleID"] = $u_google_id;
            $data["vPhone"] = $this->filter->formatActionData($u_phone, $form_config["u_phone"]);
            $data["eEmailVerified"] = $u_email_verified;
            $data["eStatus"] = $u_status;
            $data["tAboutMe"] = $u_about_me;
            $data["vLatitude"] = $u_latitude;
            $data["vLongtitude"] = $u_longtitude;
            $data["dtModifiedDate"] = $this->filter->formatActionData($u_modified_date, $form_config["u_modified_date"]);
            $data["vTempPassword"] = $u_temp_password;
            $data["vDeviceToken"] = $u_device_token;
            $data["vCoverPhoto"] = $u_cover_photo;
            $data["dDOB"] = $this->filter->formatActionData($u_d_ob, $form_config["u_d_ob"]);
            $data["eGender"] = $u_gender;
            $data["vCoverYDimention"] = $u_cover_ydimention;
            $data["vCoverVideo"] = $u_cover_video;
            $data["vAppleId"] = $u_apple_id;
            $data["dtVpUpdateDate"] = $this->filter->formatActionData($u_vp_update_date, $form_config["u_vp_update_date"]);
            $data["dtMyFeedUpdateDate"] = $this->filter->formatActionData($u_my_feed_update_date, $form_config["u_my_feed_update_date"]);
            $data["vCvHeight"] = $u_cv_height;
            $data["vCvWidth"] = $u_cv_width;
            $data["eSubscribeEmail"] = $u_subscribe_email;
            $data["iUnsubscribeReasonsId"] = $u_unsubscribe_reasons_id;
            $data["eNotificationPref"] = $u_notification_pref;
            $data["ePrivacy"] = $u_privacy;
            $data["eDeviceType"] = $u_device_type;
            $data["vDeviceName"] = $u_device_name;
            $data["vDeviceOs"] = $u_device_os;
            $data["vAppVersion"] = $u_app_version;
            $data["dAddedDate"] = $this->filter->formatActionData($u_added_date, $form_config["u_added_date"]);
            $data["dLastLogin"] = $this->filter->formatActionData($u_last_login, $form_config["u_last_login"]);

            $save_data_arr["u_profile_image"] = $data["vProfileImage"];
            $save_data_arr["u_name"] = $data["vName"];
            $save_data_arr["u_email"] = $data["vEmail"];
            $save_data_arr["u_password"] = $data["vPassword"];
            $save_data_arr["u_facebook_id"] = $data["vFacebookId"];
            $save_data_arr["u_google_id"] = $data["vGoogleID"];
            $save_data_arr["u_phone"] = $data["vPhone"];
            $save_data_arr["u_email_verified"] = $data["eEmailVerified"];
            $save_data_arr["u_status"] = $data["eStatus"];
            $save_data_arr["u_about_me"] = $data["tAboutMe"];
            $save_data_arr["u_latitude"] = $data["vLatitude"];
            $save_data_arr["u_longtitude"] = $data["vLongtitude"];
            $save_data_arr["u_modified_date"] = $data["dtModifiedDate"];
            $save_data_arr["u_temp_password"] = $data["vTempPassword"];
            $save_data_arr["u_device_token"] = $data["vDeviceToken"];
            $save_data_arr["u_cover_photo"] = $data["vCoverPhoto"];
            $save_data_arr["u_d_ob"] = $data["dDOB"];
            $save_data_arr["u_gender"] = $data["eGender"];
            $save_data_arr["u_cover_ydimention"] = $data["vCoverYDimention"];
            $save_data_arr["u_cover_video"] = $data["vCoverVideo"];
            $save_data_arr["u_apple_id"] = $data["vAppleId"];
            $save_data_arr["u_vp_update_date"] = $data["dtVpUpdateDate"];
            $save_data_arr["u_my_feed_update_date"] = $data["dtMyFeedUpdateDate"];
            $save_data_arr["u_cv_height"] = $data["vCvHeight"];
            $save_data_arr["u_cv_width"] = $data["vCvWidth"];
            $save_data_arr["u_subscribe_email"] = $data["eSubscribeEmail"];
            $save_data_arr["u_unsubscribe_reasons_id"] = $data["iUnsubscribeReasonsId"];
            $save_data_arr["u_notification_pref"] = $data["eNotificationPref"];
            $save_data_arr["u_privacy"] = $data["ePrivacy"];
            $save_data_arr["u_device_type"] = $data["eDeviceType"];
            $save_data_arr["u_device_name"] = $data["vDeviceName"];
            $save_data_arr["u_device_os"] = $data["vDeviceOs"];
            $save_data_arr["u_app_version"] = $data["vAppVersion"];
            $save_data_arr["u_added_date"] = $data["dAddedDate"];
            $save_data_arr["u_last_login"] = $data["dLastLogin"];
            if ($mode == 'Add')
            {
                $id = $this->users_model->insert($data);
                if (intval($id) > 0)
                {
                    $save_data_arr["iUsersId"] = $data["iUsersId"] = $id;
                    $msg = $this->general->processMessageLabel('ACTION_RECORD_ADDED_SUCCESSFULLY_C46_C46_C33');
                }
                else
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_ADDING_RECORD_C46_C46_C33'));
                }
                $track_cond = $this->db->protect("u.iUsersId")." = ".$this->db->escape($id);
                $switch_combo = $this->users_model->getSwitchTo($track_cond);
                $recName = $switch_combo[0]["val"];
                $this->general->trackModuleNavigation("Module", "Form", "Added", $this->mod_enc_url["add"], "users", $recName, "mode|".$this->general->getAdminEncodeURL("Update")."|id|".$this->general->getAdminEncodeURL($id));
            }
            elseif ($mode == 'Update')
            {
                $res = $this->users_model->update($data, intval($id));
                if (intval($res) > 0)
                {
                    $save_data_arr["iUsersId"] = $data["iUsersId"] = $id;
                    $msg = $this->general->processMessageLabel('ACTION_RECORD_SUCCESSFULLY_UPDATED_C46_C46_C33');
                }
                else
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPDATING_OF_THIS_RECORD_C46_C46_C33'));
                }
                $track_cond = $this->db->protect("u.iUsersId")." = ".$this->db->escape($id);
                $switch_combo = $this->users_model->getSwitchTo($track_cond);
                $recName = $switch_combo[0]["val"];
                $this->general->trackModuleNavigation("Module", "Form", "Modified", $this->mod_enc_url["add"], "users", $recName, "mode|".$this->general->getAdminEncodeURL("Update")."|id|".$this->general->getAdminEncodeURL($id));
            }
            $ret_arr['id'] = $id;
            $ret_arr['mode'] = $mode;
            $ret_arr['message'] = $msg;
            $ret_arr['success'] = 1;

            $file_data["u_profile_image"]["file_name"] = $u_profile_image;
            $file_data["u_profile_image"]["old_file_name"] = $params_arr["old_u_profile_image"];
            $file_data["u_profile_image"]["unique_name"] = "u_profile_image";
            $file_data["u_profile_image"]["primary_key"] = "iUsersId";

            $this->listing->uploadFilesOnSaveForm($file_data, $form_config, $save_data_arr);

            $params_arr = $this->_request_params();
        }
        catch(Exception $e)
        {
            $ret_arr["message"] = $e->getMessage();
            $ret_arr["success"] = 0;
        }
        $ret_arr['mod_enc_url']['add'] = $this->mod_enc_url['add'];
        $ret_arr['mod_enc_url']['index'] = $this->mod_enc_url['index'];
        $ret_arr['red_type'] = 'List';
        $this->filter->getPageFlowURL($ret_arr, $this->module_config, $params_arr, $id, $data);

        $this->response_arr = $ret_arr;
        echo json_encode($ret_arr);
        $this->skip_template_view();
    }

    /**
     * inlineEditAction method is used to save inline editing data records, status field updation,
     * delete records either from grid listing or update form, saving inline adding records from grid
     */
    public function inlineEditAction()
    {
        $params_arr = $this->params_arr;
        $operartor = $params_arr['oper'];
        $all_row_selected = $params_arr['AllRowSelected'];
        $primary_ids = explode(",", $params_arr['id']);
        $primary_ids = count($primary_ids) > 1 ? $primary_ids : $primary_ids[0];
        $filters = $params_arr['filters'];
        $filters = json_decode($filters, TRUE);
        $extra_cond = '';
        $search_mode = $search_join = $search_alias = 'No';
        if ($all_row_selected == "true" && in_array($operartor, array("del", "status")))
        {
            $module_where = $this->users_model->extra_cond;
            if ($module_where != "")
            {
                $extra_cond .= ($extra_cond != "") ? " AND (".$module_where.")" : $module_where;
            }
            $search_mode = ($operartor == "del") ? "Delete" : "Update";
            $search_join = $search_alias = "Yes";
            $config_arr['module_name'] = $this->module_name;
            $config_arr['list_config'] = $this->users_model->getListConfiguration();
            $config_arr['form_config'] = $this->users_model->getFormConfiguration();
            $config_arr['table_name'] = $this->users_model->table_name;
            $config_arr['table_alias'] = $this->users_model->table_alias;
            $filter_main = $this->filter->applyFilter($filters, $config_arr, $search_mode);
            $filter_left = $this->filter->applyLeftFilter($filters, $config_arr, $search_mode);
            $filter_range = $this->filter->applyRangeFilter($filters, $config_arr, $search_mode);
            if ($filter_main != "")
            {
                $extra_cond .= ($extra_cond != "") ? " AND (".$filter_main.")" : $filter_main;
            }
            if ($filter_left != "")
            {
                $extra_cond .= ($extra_cond != "") ? " AND (".$filter_left.")" : $filter_left;
            }
            if ($filter_range != "")
            {
                $extra_cond .= ($extra_cond != "") ? " AND (".$filter_range.")" : $filter_range;
            }
        }
        if ($search_alias == "Yes")
        {
            $primary_field = $this->users_model->table_alias.".".$this->users_model->primary_key;
        }
        else
        {
            $primary_field = $this->users_model->primary_key;
        }
        if (is_array($primary_ids))
        {
            $pk_condition = $this->db->protect($primary_field)." IN ('".implode("','", $primary_ids)."')";
        }
        elseif (intval($primary_ids) > 0)
        {
            $pk_condition = $this->db->protect($primary_field)." = ".$this->db->escape($primary_ids);
        }
        else
        {
            $pk_condition = FALSE;
        }
        if ($all_row_selected == "true" && in_array($operartor, array("del", "status")))
        {
            $pk_condition = $this->db->protect($primary_field)." > 0";
        }
        if ($pk_condition)
        {
            $extra_cond .= ($extra_cond != "") ? " AND (".$pk_condition.")" : $pk_condition;
        }
        $data_arr = $save_data_arr = array();
        try
        {
            switch ($operartor)
            {
                case 'del':
                    $mode = "Delete";
                    if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
                    {
                        $del_access = $this->filter->checkAccessCapability("users_delete", TRUE);
                    }
                    else
                    {
                        $del_access = $this->filter->getModuleWiseAccess("users", "Delete", TRUE, TRUE);
                    }
                    if (!$del_access)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_DELETE_THESE_DETAILS_C46_C46_C33'));
                    }
                    if ($search_mode == "No" && $pk_condition == FALSE)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_DELETION_THIS_RECORD_C46_C46_C33'));
                    }
                    $params_arr = $this->_request_params();
                    if (is_array($primary_ids))
                    {
                        $main_cond = $this->db->protect("u.iUsersId")." IN ('".implode("','", $primary_ids)."')";
                    }
                    else
                    {
                        $main_cond = $this->db->protect("u.iUsersId")." = ".$this->db->escape($primary_ids);
                    }
                    $main_data = $this->users_model->getData($main_cond, array('u.vProfileImage'));
                    $success = $this->users_model->delete($extra_cond, $search_alias, $search_join);
                    if (!$success)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_DELETION_THIS_RECORD_C46_C46_C33'));
                    }
                    $message = $this->general->processMessageLabel('ACTION_RECORD_C40S_C41_DELETED_SUCCESSFULLY_C46_C46_C33');

                    $form_config = $this->users_model->getFormConfiguration();
                    $this->general->deleteMediaFiles($form_config, $main_data, $this->module_config["physical_data_remove"]);
                    break;
                case 'edit':
                    $mode = "Update";
                    if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
                    {
                        $edit_access = $this->filter->checkAccessCapability("users_update", TRUE);
                    }
                    else
                    {
                        $edit_access = $this->filter->getModuleWiseAccess("users", "Update", TRUE, TRUE);
                    }
                    if (!$edit_access)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_MODIFY_THESE_DETAILS_C46_C46_C33'));
                    }
                    $post_name = $params_arr['name'];
                    $post_val = is_array($params_arr['value']) ? implode(",", $params_arr['value']) : $params_arr['value'];

                    $list_config = $this->users_model->getListConfiguration($post_name);
                    $form_config = $this->users_model->getFormConfiguration($list_config['source_field']);
                    if (!is_array($form_config) || count($form_config) == 0)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FORM_CONFIGURING_NOT_DONE_C46_C46_C33'));
                    }
                    if (in_array($form_config['type'], array("date", "date_and_time", "time", 'phone_number')))
                    {
                        $post_val = $this->filter->formatActionData($post_val, $form_config);
                    }
                    if ($form_config["encrypt"] == "Yes")
                    {
                        $post_val = $this->general->encryptDataMethod($post_val, $form_config["enctype"]);
                    }
                    $field_name = $form_config['field_name'];
                    $unique_name = $form_config['name'];

                    $db_rec_arr = $this->users_model->getData(intval($primary_ids));
                    $unique_arr = array();

                    $unique_arr[$field_name] = $post_val;
                    if (in_array($field_name, $this->users_model->unique_fields))
                    {
                        $unique_exists = $this->users_model->checkRecordExists($this->users_model->unique_fields, $unique_arr, $primary_ids, "Update", $this->users_model->unique_type);
                        if ($unique_exists)
                        {
                            $error_msg = $this->general->processMessageLabel('ACTION_RECORD_ALREADY_EXISTS_WITH_THESE_DETAILS_OF_EMAIL_C46_C46_C33');
                            if ($error_msg == "")
                            {
                                $error_msg = "Record already exists with these details of Email";
                            }
                            throw new Exception($error_msg);
                        }
                    }

                    $data_arr[$field_name] = $post_val;
                    $success = $this->users_model->update($data_arr, intval($primary_ids));
                    $message = $this->general->processMessageLabel('ACTION_RECORD_SUCCESSFULLY_UPDATED_C46_C46_C33');
                    if (!$success)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPDATING_OF_THIS_RECORD_C46_C46_C33'));
                    }
                    break;
                case 'status':
                    $mode = "Status";
                    if ($this->config->item("ENABLE_ROLES_CAPABILITIES"))
                    {
                        $edit_access = $this->filter->checkAccessCapability("users_update", TRUE);
                    }
                    else
                    {
                        $edit_access = $this->filter->getModuleWiseAccess("users", "Update", TRUE, TRUE);
                    }
                    if (!$edit_access)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_MODIFY_THESE_DETAILS_C46_C46_C33'));
                    }
                    if ($search_mode == "No" && $pk_condition == FALSE)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_DELETION_THIS_RECORD_C46_C46_C33'));
                    }
                    $status_field = "eStatus";
                    if ($status_field == "")
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FORM_CONFIGURING_NOT_DONE_C46_C46_C33'));
                    }
                    if ($search_mode == "Yes" || $search_alias == "Yes")
                    {
                        $field_name = $this->users_model->table_alias.".eStatus";
                    }
                    else
                    {
                        $field_name = $status_field;
                    }
                    $data_arr[$field_name] = $params_arr['status'];
                    $success = $this->users_model->update($data_arr, $extra_cond, $search_alias, $search_join);
                    if (!$success)
                    {
                        throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_MODIFYING_THESE_RECORDS_C46_C46_C33'));
                    }
                    $message = $this->general->processMessageLabel('ACTION_RECORD_C40S_C41_MODIFIED_SUCCESSFULLY_C46_C46_C33');
                    break;
            }
            $ret_arr['success'] = "true";
            $ret_arr['message'] = $message;
            if ($mode == "Update")
            {
                $save_data_arr = $db_rec_arr[0];
                $save_data_arr[$unique_name] = $post_val;
                if ($form_config["type"] == "file")
                {
                    $file_data[$unique_name]["file_name"] = $post_val;
                    $file_data[$unique_name]["old_file_name"] = $params_arr["old_file"];
                    $file_data[$unique_name]["unique_name"] = $unique_name;
                    $file_data[$unique_name]["primary_key"] = "iUsersId";
                    $this->listing->uploadFilesOnSaveForm($file_data, array($unique_name => $form_config), $save_data_arr);
                }
            }
        }
        catch(Exception $e)
        {
            $ret_arr["success"] = "false";
            $ret_arr["message"] = $e->getMessage();
        }
        $this->response_arr = $ret_arr;
        echo json_encode($ret_arr);
        $this->skip_template_view();
    }

    /**
     * processConfiguration method is used to process add and edit permissions for grid intialization
     */
    protected function processConfiguration(&$list_config = array(), $isAdd = TRUE, $isEdit = TRUE, $runCombo = FALSE)
    {
        if (!is_array($list_config) || count($list_config) == 0)
        {
            return $list_config;
        }
        $count_arr = array();
        foreach ((array) $list_config as $key => $val)
        {
            if (!$isAdd)
            {
                $list_config[$key]["addable"] = "No";
            }
            if (!$isEdit)
            {
                $list_config[$key]["editable"] = "No";
            }

            $source_field = $val['source_field'];
            $dropdown_arr = $this->dropdown_arr[$source_field];
            if (is_array($dropdown_arr) && in_array($val['type'], array("dropdown", "radio_buttons", "checkboxes", "multi_select_dropdown")))
            {
                $count_arr[$key]['ajax'] = "No";
                $count_arr[$key]['json'] = "No";
                $count_arr[$key]['data'] = array();
                $combo_arr = FALSE;
                if ($dropdown_arr['auto'] == "Yes")
                {
                    $combo_arr = $this->getSourceOptions($source_field, "Search", '', array(), '', 'count');
                    if ($combo_arr[0]['tot'] > $this->dropdown_limit)
                    {
                        $count_arr[$key]['ajax'] = "Yes";
                    }
                }
                if ($runCombo == TRUE)
                {
                    if (in_array($dropdown_arr['type'], array("enum", "phpfn")))
                    {
                        $data_arr = $this->getSourceOptions($source_field, "Search");
                        $json_arr = $this->filter->makeArrayDropdown($data_arr);
                        $count_arr[$key]['json'] = "Yes";
                        $count_arr[$key]['data'] = json_encode($json_arr);
                    }
                    else
                    {
                        if ($dropdown_arr['opt_group'] != "Yes")
                        {
                            if ($combo_arr == FALSE)
                            {
                                $combo_arr = $this->getSourceOptions($source_field, "Search", '', array(), '', 'count');
                            }
                            if ($combo_arr[0]['tot'] < $this->search_combo_limit)
                            {
                                $data_arr = $this->getSourceOptions($source_field, "Search");
                                $json_arr = $this->filter->makeArrayDropdown($data_arr);
                                $count_arr[$key]['json'] = "Yes";
                                $count_arr[$key]['data'] = json_encode($json_arr);
                            }
                        }
                    }
                }
            }
        }
        $this->count_arr = $count_arr;
        return $list_config;
    }

    /**
     * getSourceOptions method is used to get data array of enum, table, token or php function input types
     * @param string $name unique name of form configuration field.
     * @param string $mode mode for add or update form.
     * @param string $id update record id of add or update form.
     * @param array $data data array of add or update record.
     * @param string $extra extra query condition for searching data array.
     * @param string $rtype type for getting either records list or records count.
     * @return array $data_arr returns data records array
     */
    public function getSourceOptions($name = '', $mode = 'Add', $id = '', $data = array(), $extra = '', $rtype = 'records')
    {
        $combo_config = $this->dropdown_arr[$name];
        $data_arr = array();
        if (!is_array($combo_config) || count($combo_config) == 0)
        {
            return $data_arr;
        }
        $type = $combo_config['type'];
        switch ($type)
        {
            case 'enum':
                $data_arr = is_array($combo_config['values']) ? $combo_config['values'] : array();
                break;
            case 'token':
                if ($combo_config['parent_src'] == "Yes" && in_array($mode, array("Add", "Update", "Auto")))
                {
                    $source_field = $combo_config['source_field'];
                    $target_field = $combo_config['target_field'];
                    if (in_array($mode, array("Update", "Auto")) || $data[$source_field] != "")
                    {
                        $parent_src = (is_array($data[$source_field])) ? $data[$source_field] : explode(",", $data[$source_field]);
                        $extra_cond = $this->db->protect($target_field)." IN ('".implode("','", $parent_src)."')";
                    }
                    elseif ($mode == "Add")
                    {
                        $extra_cond = $this->db->protect($target_field)." = ''";
                    }
                    $extra = (trim($extra) != "") ? $extra." AND ".$extra_cond : $extra_cond;
                }
                $data_arr = $this->filter->getTableLevelDropdown($combo_config, $id, $extra, $rtype);
                break;
            case 'table':
                if ($combo_config['auto'] == "Yes" && $mode == "Update")
                {
                    if (!empty($data[$name]))
                    {
                        $selected_rec = (is_array($data[$name])) ? $data[$name] : explode(",", $data[$name]);
                        $selected_rec = $this->general->escape_str($selected_rec);
                        $selected_str = implode(",", $selected_rec);
                        $combo_config['order_by'] = "FIELD(".$combo_config['field_key'].", ".$selected_str.") DESC, ".$combo_config['order_by'];
                    }
                }
                if ($combo_config['parent_src'] == "Yes" && in_array($mode, array("Add", "Update", "Auto")))
                {
                    $source_field = $combo_config['source_field'];
                    $target_field = $combo_config['target_field'];
                    if (in_array($mode, array("Update", "Auto")) || $data[$source_field] != "")
                    {
                        $parent_src = (is_array($data[$source_field])) ? $data[$source_field] : explode(",", $data[$source_field]);
                        $extra_cond = $this->db->protect($target_field)." IN ('".implode("','", $parent_src)."')";
                    }
                    elseif ($mode == "Add")
                    {
                        $extra_cond = $this->db->protect($target_field)." = ''";
                    }
                    $extra = (trim($extra) != "") ? $extra." AND ".$extra_cond : $extra_cond;
                }
                if ($combo_config['parent_child'] == "Yes" && $combo_config['nlevel_child'] == "Yes")
                {
                    $combo_config['main_table'] = $this->users_model->table_name;
                    $data_arr = $this->filter->getTreeLevelDropdown($combo_config, $id, $extra, $rtype);
                }
                else
                {
                    if ($combo_config['parent_child'] == "Yes" && $combo_config['parent_field'] != "")
                    {
                        $parent_field = $combo_config['parent_field'];
                        $extra_cond = "(".$this->db->protect($parent_field)." = '0' OR ".$this->db->protect($parent_field)." = '' OR ".$this->db->protect($parent_field)." IS NULL )";
                        if ($mode == "Update" || ($mode == "Search" && $id > 0))
                        {
                            $extra_cond .= " AND ".$this->db->protect($combo_config['field_key'])." <> ".$this->db->escape($id);
                        }
                        $extra = (trim($extra) != "") ? $extra." AND ".$extra_cond : $extra_cond;
                    }
                    $data_arr = $this->filter->getTableLevelDropdown($combo_config, $id, $extra, $rtype);
                }
                break;
            case 'phpfn':
                $phpfunc = $combo_config['function'];
                $parent_src = '';
                if ($combo_config['parent_src'] == "Yes" && in_array($mode, array("Add", "Update", "Auto")))
                {
                    $source_field = $combo_config['source_field'];
                    if (in_array($mode, array("Update", "Auto")) || $data[$source_field] != "")
                    {
                        $parent_src = $data[$source_field];
                    }
                }
                if (substr($phpfunc, 0, 12) == 'controller::' && substr($phpfunc, 12) !== FALSE)
                {
                    $phpfunc = substr($phpfunc, 12);
                    if (method_exists($this, $phpfunc))
                    {
                        $data_arr = $this->$phpfunc($data[$name], $mode, $id, $data, $parent_src, $this->term);
                    }
                }
                elseif (substr($phpfunc, 0, 7) == 'model::' && substr($phpfunc, 7) !== FALSE)
                {
                    $phpfunc = substr($phpfunc, 7);
                    if (method_exists($this->users_model, $phpfunc))
                    {
                        $data_arr = $this->users_model->$phpfunc($data[$name], $mode, $id, $data, $parent_src, $this->term);
                    }
                }
                elseif (method_exists($this->general, $phpfunc))
                {
                    $data_arr = $this->general->$phpfunc($data[$name], $mode, $id, $data, $parent_src, $this->term);
                }
                break;
        }
        return $data_arr;
    }

    /**
     * getSelfSwitchToPrint method is used to provide autocomplete for switchto dropdown, which is called through form.
     */
    public function getSelfSwitchTo()
    {
        $params_arr = $this->params_arr;

        $term = strtolower($params_arr['data']['q']);

        $switchto_fields = $this->users_model->switchto_fields;
        $extra_cond = $this->users_model->extra_cond;

        $concat_fields = $this->db->concat_cast($switchto_fields);
        $search_cond = "(LOWER(".$concat_fields.") LIKE '".$this->db->escape_like_str($term)."%' OR LOWER(".$concat_fields.") LIKE '% ".$this->db->escape_like_str($term)."%')";
        $extra_cond = ($extra_cond == "") ? $search_cond : $extra_cond." AND ".$search_cond;

        $switch_arr = $this->users_model->getSwitchTo($extra_cond);
        $html_arr = $this->filter->getChosenAutoJSON($switch_arr, array(), FALSE, "auto");

        $json_array['q'] = $term;
        $json_array['results'] = $html_arr;
        $html_str = json_encode($json_array);

        echo $html_str;
        $this->skip_template_view();
    }

    /**
     * getListOptions method is used to get  dropdown values searching or inline editing in grid listing (select options in html or json string)
     */
    public function getListOptions()
    {
        $params_arr = $this->params_arr;
        $alias_name = $params_arr['alias_name'];
        $rformat = $params_arr['rformat'];
        $id = $params_arr['id'];
        $mode = ($params_arr['mode'] == "Search") ? "Search" : (($params_arr['mode'] == "Update") ? "Update" : "Add");
        $config_arr = $this->users_model->getListConfiguration($alias_name);
        $source_field = $config_arr['source_field'];
        $combo_config = $this->dropdown_arr[$source_field];
        $data_arr = array();
        if ($mode == "Update")
        {
            $data_arr = $this->users_model->getData(intval($id));
        }
        $combo_arr = $this->getSourceOptions($source_field, $mode, $id, $data_arr[0]);
        if ($rformat == "json")
        {
            $html_str = $this->filter->getChosenAutoJSON($combo_arr, $combo_config, TRUE, "grid");
        }
        else
        {
            if ($combo_config['opt_group'] == "Yes")
            {
                $combo_arr = $this->filter->makeOPTDropdown($combo_arr);
            }
            else
            {
                $combo_arr = $this->filter->makeArrayDropdown($combo_arr);
            }
            $this->dropdown->combo("array", $source_field, $combo_arr, $id);
            $top_option = (in_array($mode, array("Add", "Update")) && $combo_config['default'] == 'Yes') ? "|||" : '';
            $html_str = $this->dropdown->display($source_field, $source_field, ' multiple=true ', $top_option);
        }
        echo $html_str;
        $this->skip_template_view();
    }

    /**
     * downloadListFile method is used to download grid listing files
     */
    public function downloadListFile()
    {
        $params_arr = $this->params_arr;
        $alias_name = $params_arr['alias_name'];
        $folder = $params_arr['folder'];
        $id = $params_arr['id'];
        $config_arr = $this->users_model->getListConfiguration($alias_name);
        if (is_array($config_arr) && count($config_arr) > 0)
        {
            $fields = $config_arr['display_query']." AS ".$alias_name;
            $data_arr = $this->users_model->getData(intval($id), $fields, '', '', '', 'Yes');
            $file_name = $data_arr[0][$alias_name];
            $this->listing->downloadFiles("List", $config_arr, $file_name, $folder);
        }
        $this->skip_template_view();
    }
    /**
     * uploadFormFile method is used to upload files or images through add or update form
     */
    public function uploadFormFile()
    {
        $this->load->library('upload');
        $params_arr = $this->params_arr;
        $unique_name = $params_arr['unique_name'];
        $id = $params_arr['id'];
        $old_file = $params_arr['oldFile'];
        $type = $params_arr['type'];
        $upload_files = $_FILES['Filedata'];
        list($file_name, $extension) = $this->general->get_file_attributes($upload_files['name']);
        $this->general->createUploadFolderIfNotExists('__temp');
        $config_arr = $this->users_model->getFormConfiguration($unique_name);

        $temp_folder_path = $this->config->item('admin_upload_temp_path');
        $temp_folder_url = $this->config->item('admin_upload_temp_url');
        try
        {
            if ($type == 'webcam')
            {
                $img_pic = $params_arr['newFile'];
                $res = $this->general->imageupload_base64($temp_folder_path, $img_pic);
                if ($res[0] == FALSE)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPLOADING_C46_C46_C33'));
                }
                $file_name = $res[0];
            }
            else
            {
                $file_size = ($config_arr['file_size']) ? $config_arr['file_size'] : $this->config->item('ADMIN_MAX_UPLOAD_FILE_SIZE');
                $file_format = ($config_arr['file_format']) ? $config_arr['file_format'] : $this->config->item('IMAGE_EXTENSION_ARR');
                if ($config_arr['file_folder'] == "")
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_PLEASE_SPECIFY_THE_UPLOAD_FOLDER_NAME_C46_C46_C33'));
                }
                if ($upload_files['name'] == "")
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_UPLOAD_FILE_NOT_FOUND_C46_C46_C33'));
                }
                if (!$this->general->validateFileFormat($file_format, $file_name))
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FILE_TYPE_IS_NOT_ACCEPTABLE'));
                }
                if (!$this->general->validateFileSize($file_size, $upload_files['size']))
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FILE_SIZE_NOT_A_VALID_ONE_C46_C46_C33'));
                }
                $upload_config = array(
                    'upload_path' => $temp_folder_path,
                    'allowed_types' => '*',
                    'max_size' => $file_size,
                    'file_name' => $file_name,
                    'remove_space' => TRUE,
                    'overwrite' => FALSE,
                );
                $this->upload->initialize($upload_config);
                if (!$this->upload->do_upload('Filedata'))
                {
                    $upload_error = $this->upload->display_errors('', '');
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPLOADING_C46_C46_C33'));
                }
                $file_info = $this->upload->data();
                $file_name = $file_info['file_name'];
            }
            if (!$file_name)
            {
                throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPLOADING_C46_C46_C33'));
            }
            if (substr($upload_files['type'], 0, 5) == 'image')
            {
                $check_img_dimensions = 0;
                if (!empty($config_arr['min_dimension']))
                {
                    $tmp_min_arr = explode('X', strtoupper($config_arr['min_dimension']));
                    $img_min_width = $tmp_min_arr[0];
                    $img_min_height = $tmp_min_arr[1];
                    $check_img_dimensions = ($img_min_width > 0 && $img_min_height > 0) ? 1 : 0;
                }
                if (!empty($config_arr['max_dimension']))
                {
                    $tmp_max_arr = explode('X', strtoupper($config_arr['max_dimension']));
                    $img_max_width = $tmp_max_arr[0];
                    $img_max_height = $tmp_max_arr[1];
                    $check_img_dimensions = ($img_max_width > 0 && $img_max_height > 0) ? 1 : 0;
                }
                if ($check_img_dimensions)
                {
                    $img_arr = getimagesize($temp_folder_url.$file_name);
                    $img_width = $img_arr[0];
                    $img_height = $img_arr[1];
                    if ($img_width > 0)
                    {
                        if ($img_min_width > 0 && $img_width < $img_min_width)
                        {
                            throw new Exception($this->general->processMessageLabel('IMAGE_MIN_WIDTH_SHOULD_BE').$img_min_width);
                        }
                        if ($img_max_width > 0 && $img_width > $img_max_width)
                        {
                            throw new Exception($this->general->processMessageLabel('IMAGE_MAX_WIDTH_SHOULD_BE').$img_max_width);
                        }
                    }
                    if ($img_height > 0)
                    {
                        if ($img_min_height > 0 && $img_height < $img_min_height)
                        {
                            throw new Exception($this->general->processMessageLabel('IMAGE_MIN_HEIGHT_SHOULD_BE').$img_min_height);
                        }
                        if ($img_max_height > 0 && $img_height > $img_max_height)
                        {
                            throw new Exception($this->general->processMessageLabel('IMAGE_MAX_HEIGHT_SHOULD_BE').$img_max_height);
                        }
                    }
                }
            }
            $image_valid_ext = explode('.', $file_name);
            $ret_arr['fileURL'] = $temp_folder_url.$file_name;
            if (in_array(strtolower(end($image_valid_ext)), $this->config->item('IMAGE_EXTENSION_ARR')))
            {
                $ret_arr['width'] = ($config_arr['file_width']) ? $config_arr['file_width'] : $this->config->item('ADMIN_DEFAULT_IMAGE_WIDTH');
                $ret_arr['height'] = ($config_arr['file_height']) ? $config_arr['file_height'] : $this->config->item('ADMIN_DEFAULT_IMAGE_HEIGHT');
                $ret_arr['imgURL'] = $this->general->resize_image($temp_folder_url.$file_name, $ret_arr['width'], $ret_arr['height']);
                $ret_arr['resized'] = 1;
                $icon_class = 'fa-file-image-o';
            }
            else
            {
                $icon_class = 'fa-file-text-o';
                $ret_arr['resized'] = 0;
            }
            $icon_file = $file_name;
            if (function_exists("get_file_icon_class"))
            {
                $icon_class = get_file_icon_class($file_name);
                $icon_file = format_uploaded_file($file_name);
            }
            $ret_arr['iconclass'] = $icon_class;
            $ret_arr['iconfile'] = $icon_file;
            $ret_arr['filename'] = $icon_file;
            if (is_file($temp_folder_path.$old_file) && $old_file != '')
            {
                unlink($temp_folder_path.$old_file);
            }

            $ret_arr['success'] = 1;
            $ret_arr['message'] = $this->general->processMessageLabel('ACTION_FILE_UPLOADED_SUCCESSFULLY_C46_C46_C33');
            $ret_arr['uploadfile'] = $file_name;
            $ret_arr['oldfile'] = $file_name;
        }
        catch(Exception $e)
        {
            $ret_arr['success'] = 0;
            $ret_arr['message'] = $e->getMessage();
        }
        echo json_encode($ret_arr);
        $this->skip_template_view();
    }
    /**
     * downloadFormFile method is used to download add or update form files
     */
    public function downloadFormFile()
    {
        $params_arr = $this->params_arr;
        $unique_name = $params_arr['unique_name'];
        $folder = $params_arr['folder'];
        $id = $params_arr['id'];
        $config_arr = $this->users_model->getFormConfiguration($unique_name);
        try
        {
            if (!is_array($config_arr) || count($config_arr) == 0)
            {
                throw new Exception($this->general->processMessageLabel('ACTION_FORM_CONFIGURING_NOT_DONE_C46_C46_C33'));
            }
            if ($config_arr['entry_type'] == "Custom")
            {
                $file_name = $params_arr['file'];
            }
            else
            {
                $fields = $config_arr['table_alias'].".".$config_arr['field_name']." AS ".$unique_name;
                $data_arr = $this->users_model->getData(intval($id), $fields, '', '', '', 'Yes');
                if (!is_array($data_arr) || count($data_arr) == 0)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_RECORDS_WHICH_YOU_ARE_TRYING_TO_ACCESS_ARE_NOT_AVAILABLE_C46_C46_C33'));
                }
                $file_name = $data_arr[0][$unique_name];
            }
            $this->listing->downloadFiles("Form", $config_arr, $file_name, $folder);
        }
        catch(Exception $e)
        {
            $ret_arr['success'] = 0;
            $ret_arr['message'] = $e->getMessage();
            echo json_encode($ret_arr);
        }
        $this->skip_template_view();
    }
    /**
     * deleteFormFile method is used to delete add or update form files
     */
    public function deleteFormFile()
    {
        $params_arr = $this->params_arr;
        $unique_name = $params_arr['unique_name'];
        $folder = $params_arr['folder'];
        $id = $params_arr['id'];
        $config_arr = $this->users_model->getFormConfiguration($unique_name);
        try
        {
            if (!is_array($config_arr) || count($config_arr) == 0)
            {
                throw new Exception($this->general->processMessageLabel('ACTION_FORM_CONFIGURING_NOT_DONE_C46_C46_C33'));
            }
            if ($config_arr['entry_type'] == "Custom")
            {
                //custom fields does not have delete from DB.
                $file_name = $params_arr['file'];
            }
            else
            {
                $field_name = $config_arr['field_name'];
                $fields = $config_arr['table_alias'].".".$field_name." AS ".$unique_name;
                $data_arr = $this->users_model->getData(intval($id), $fields, '', '', '', 'Yes');
                if (!is_array($data_arr) || count($data_arr) == 0)
                {
                    throw new Exception();
                }
                $fields = $config_arr['table_alias'].'.'.$field_name.' AS '.$unique_name;
                $data_arr = $this->users_model->getData(intval($id), $fields, '', '', '', 'Yes');
                if (!is_array($data_arr) || count($data_arr) == 0)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_RECORDS_WHICH_YOU_ARE_TRYING_TO_ACCESS_ARE_NOT_AVAILABLE_C46_C46_C33'));
                }
                $fields = $config_arr['table_alias'].'.'.$field_name.' AS '.$unique_name;
                $data_arr = $this->users_model->getData(intval($id), $fields, '', '', '', 'Yes');
                if (!is_array($data_arr) || count($data_arr) == 0)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_RECORDS_WHICH_YOU_ARE_TRYING_TO_ACCESS_ARE_NOT_AVAILABLE_C46_C46_C33'));
                }
                $update_arr[$field_name] = '';
                $res = $this->users_model->update($update_arr, intval($id));
                if (!$res)
                {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_FILE_DELETION_C46_C46_C33'));
                }
                $file_name = $data_arr[0][$unique_name];
            }
            $res = $this->listing->deleteFiles($config_arr, $file_name, $folder, "Form");
            if (!$res)
            {
                throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_FILE_DELETION_C46_C46_C33'));
            }
            $success = 1;
            $message = $this->general->processMessageLabel('ACTION_FILE_DELETED_SUCCESSFULLY_C46_C46_C33');
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $ret_arr['success'] = $success;
        $ret_arr['message'] = $message;
        echo json_encode($ret_arr);
        $this->skip_template_view();
    }
}
