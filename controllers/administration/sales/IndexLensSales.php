<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TypeLensesAdmin
 *
 * @author Veljko
 */
class IndexLensSales extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('equipment_model');
        $this->load->model('blog_model');
        $this->load->model('company_information_model');
        $this->load->model('slider_model');
        $this->load->model('text_site_model');
        $this->load->model('list_site_model');
        $this->load->model('users_model');
        $this->load->model('index_lenses_model');
    }

    public function index() {

        if (empty($this->session->userdata('id_role'))):
            redirect('Home');
        endif;

        $id_role = $this->session->userdata('id_role');

        $data['id_role'] = $id_role;
        if ($id_role == 1):
            $this->menu_model->admin = 1;
        elseif ($id_role == 2):
            $this->menu_model->user = 1;
        else:
            $this->menu_model->visitor = 1;
        endif;
        $data['menu'] = $this->menu_model->select();

        $this->load->model('menu_model', 'submenu');
        $this->submenu->where = 'parent != 0';
        $data['submenu'] = $this->submenu->select();

        $this->load->model('menu_model', 'title_page');
        $data['title_page'] = $this->title_page->select();

        $data['user'] = $this->users_model->select();

        $data['company'] = $this->company_information_model->select();

        $order_by_index_lens = "index_lenses.name_index_lens ASC";
        $this->index_lenses_model->order_by = $order_by_index_lens;
        $index_lens = $this->index_lenses_model->select();
        $data['index_lens'] = $index_lens;

        $data['title'] = "Spisak indexa sočiva";
        $view = "sales/IndexLensHome";
        $this->load_view_admin($view, $data);
    }

    public function insert() {
        if (empty($this->session->userdata('id_role'))):
            redirect('Home');
        endif;

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):

            $button = $this->input->post('btnAdd');
            if ($button != ""):
                $name_index_lens = trim($this->input->post('tbNameIndexLens'));

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

                $this->form_validation->set_rules('tbNameIndexLens', 'index sočiva', 'xss_clean|callback_name');

                if ($this->form_validation->run()):

                    //unosenje podatak u model za upis u bazu
                    $this->index_lenses_model->name_index_lens = $name_index_lens;

                    $result_index_lens = $this->index_lenses_model->insert();

                    if ($result_index_lens != ""):
                        $this->session->set_flashdata("message", "<div class='alert alert-success' style='width: 400px; text-align: center; margin:0px auto'>Uspešno ste dodali nov index sočiva!</div>");
                    else:
                        $this->session->set_flashdata("message", "<div class='alert alert-danger' style='width: 400px; text-align: center; margin:0px auto'>Dodavanje novog indexa sočiva nije uspelo!</div>");
                    endif;
                else:
                    $data_insert['name_index_lens'] = $name_index_lens;
                    $this->session->set_flashdata("message", "<div class='alert alert-danger' style='width: 400px; text-align: center; margin:0px auto'>Proverite da li ste uneli podatke ispravno!</div>");
                endif;
            endif;
        endif;

        $data['form_index_lens'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $data['form_name_index_lens'] = array(
            'name' => 'tbNameIndexLens',
            'id' => 'tbNameIndexLens',
            'value' => isset($data_insert['name_index_lens']) ? $data_insert['name_index_lens'] : '',
            'placeholder' => 'Naziv novog indexa sočiva'
        );
        $data['form_add_submit'] = array(
            'name' => 'btnAdd',
            'id' => 'btnAdd',
            'value' => 'Dodaj',
            'style' => 'width: 80px; font-weight: bold; padding: 7px; border-radius: 10px',
            'class' => 'btn-primary'
        );

        $id_role = $this->session->userdata('id_role');

        $data['id_role'] = $id_role;
        if ($id_role == 1):
            $this->menu_model->admin = 1;
        elseif ($id_role == 2):
            $this->menu_model->user = 1;
        else:
            $this->menu_model->visitor = 1;
        endif;
        $data['menu'] = $this->menu_model->select();

        $this->load->model('menu_model', 'submenu');
        $this->submenu->where = 'parent != 0';
        $data['submenu'] = $this->submenu->select();

        $this->load->model('menu_model', 'title_page');
        $data['title_page'] = $this->title_page->select();

        $data['user'] = $this->users_model->select();

        $data['company'] = $this->company_information_model->select();

        $data['title'] = "Dodavanje novog dizajna sočiva";
        $view = "sales/add-edit/AddEditIndexLens";
        $this->load_view_admin($view, $data);
    }

    public function edit($id_e = null) {

        if (empty($this->session->userdata('id_role'))):
            redirect('Home');
        endif;

        $where_index_lens = array(
            'id_index_lens' => $id_e
        );

        $this->index_lenses_model->where = $where_index_lens;
        $index_lens = $this->index_lenses_model->select();

        $data['index_lens'] = $index_lens;

        $data['form_index_lens'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $data['form_name_index_lens'] = array(
            'name' => 'tbNameIndexLens',
            'id' => 'tbNameIndexLens',
            'value' => $index_lens[0]->name_index_lens,
            'placeholder' => 'Index sočiva',
            'size' => '30px'
        );

        $data['form_add_submit'] = array(
            'name' => 'btnEdit',
            'id' => 'btnEdit',
            'value' => 'Izmeni',
            'style' => 'width: 80px; font-weight: bold; padding: 7px; border-radius: 10px',
            'class' => 'btn-primary'
        );

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):
            $button = $this->input->post('btnEdit');
            if ($button != ""):
                $name_index_lens = trim($this->input->post('tbNameIndexLens'));

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

                $this->form_validation->set_rules('tbNameIndexLens', 'index sočiva', 'xss_clean|callback_name');

                if ($this->form_validation->run()):

                    //ucitavanje podataka u model za upis u bazu
                    $this->index_lenses_model->id_index_lens = $id_e;
                    $this->index_lenses_model->name_index_lens = $name_index_lens;


                    $result_index_lens = $this->index_lenses_model->update();

                    if ($result_index_lens != ""):
                        $this->session->set_flashdata("message", "<div class='alert alert-success' style='width: 400px; text-align: center; margin:0px auto'>Uspešno ste izmenili index sočiva!</div>");
                        $data_insert['name_index_lens'] = $name_index_lens;

                        $data['form_name_index_lens'] = array(
                            'name' => 'tbNameIndexLens',
                            'id' => 'tbNameIndexLens',
                            'value' => isset($data_insert['name_index_lens']) ? $data_insert['name_index_lens'] : '',
                            'placeholder' => 'Index sočiva',
                            'size' => '30px'
                        );
                    else:
                        $this->session->set_flashdata("message", "<div class='alert alert-danger' style='width: 400px; text-align: center; margin:0px auto'>Izmena nije uspela!</div>");
                        $data_insert['name_index_lens'] = $name_index_lens;
                    endif;
                else:
                    $this->session->set_flashdata("message", "<div class='alert alert-danger' style='width: 400px; text-align: center; margin:0px auto'>Proverite da li ste uneli podatke ispravno!</div>");
                    $data_insert['name_index_lens'] = $name_index_lens;
                endif;
            endif;
        endif;

        $id_role = $this->session->userdata('id_role');

        $data['id_role'] = $id_role;
        if ($id_role == 1):
            $this->menu_model->admin = 1;
        elseif ($id_role == 2):
            $this->menu_model->user = 1;
        else:
            $this->menu_model->visitor = 1;
        endif;
        $data['menu'] = $this->menu_model->select();

        $this->load->model('menu_model', 'submenu');
        $this->submenu->where = 'parent != 0';
        $data['submenu'] = $this->submenu->select();

        $this->load->model('menu_model', 'title_page');
        $data['title_page'] = $this->title_page->select();

        $data['user'] = $this->users_model->select();

        $data['company'] = $this->company_information_model->select();

        $data['true'] = 1;

        $data['title'] = "Izmena indexa sočiva: ";
        $view = "sales/add-edit/AddEditIndexLens";
        $this->load_view_admin($view, $data);
    }

    public function delete($id_p = null) {

        if (empty($this->session->userdata('id_role'))):
            redirect('Home');
        endif;

        if ($id_p != null):
            $this->load->model('pricelist_lenses_model');
            $wherePriceListLens = array(
                'pricelist_lenses.id_index_lens' => $id_p
            );
            $this->pricelist_lenses_model->where = $wherePriceListLens;
            $result = $this->pricelist_lenses_model->select();
            if ($result != null):
                $this->session->set_flashdata('message', "<div class='alert alert-danger' style='width: 600px; text-align: center; margin:0px auto'>Index sočiva je unet u cenovnik! Izbrišite index sočiva iz cenovnika pa onda obrišite index sočiva!</div>");
                redirect('administration/sales/IndexLensSales');
            else:

                $this->index_lenses_model->id_index_lens = $id_p;
                $result = $this->index_lenses_model->delete();
                if ($result == true):
                    $this->session->set_flashdata('message', "<div class='alert alert-success' style='width: 400px; text-align: center; margin:0px auto'>Uspešno ste obrisali index sočiva!</div>");
                    redirect('administration/sales/IndexLensSales');
                else:
                    $this->session->set_flashdata("message", "<div class='alert alert-danger' style='width: 400px; text-align: center; margin:0px auto'>Greška! Niste obrisali index sočiva!</div>");
                    redirect('administration/sales/IndexLensSales');
                endif;
            endif;
        else:
            redirect('administration/sales/IndexLensSales');
        endif;
    }

    public function name($str) {
//        $regExp = "/^\d{1,}$/";
        $regExp = "/^([A-ZŠĐŽĆČa-zđšžćč\d\s\.\:\"\!\?\'\`\s\_\-\/\,\\\*\+\\(\)\']{1,}){1,}$/";
        if ($str != ""):
            if (!preg_match($regExp, $str)):
                $this->form_validation->set_message('name', "<script>"
                        . "$(document).ready(function () { "
                        . "$('.tbNameIndexLens').css('border', '1px solid red');"
                        . "$('.tbNameIndexLensCss').css('display', 'block');"
                        . "$('.tbNameIndexLensCss').text('U polje za {field} nisu uneti ispravno podaci!'); "
                        . "});"
                        . "</script>");
                return FALSE;
            else:
                return TRUE;
            endif;
        else:
            $this->form_validation->set_message('name', "<script>"
                    . "$(document).ready(function () { "
                    . "$('.tbNameIndexLens').css('border', '1px solid red');"
                    . "$('.tbNameIndexLensCss').css('display', 'block');"
                    . "$('.tbNameIndexLensCss').text('* Polje za {field} mora biti uneto!'); "
                    . "});"
                    . "</script>");
            return FALSE;
        endif;
    }

}
