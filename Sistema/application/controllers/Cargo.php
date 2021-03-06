<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cargo extends MY_Controller {

    public $page_title = "Cargos";
    public $empresas = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('Cargo_model','cargo');
        $this->load->model('Empresa_model','empresa');
        $this->empresas = $this->empresa->get_dropdown();
    }
    
    public function index() {
        $this->listar();
    }
    
    public function listar($header = false) {

        $data = array(
            "header" => $header,
            "page_title" => $this->page_title,
            "page_subtitle" => "",
            "empresas" => $this->empresas,
            "dados" => $this->cargo->listar($this->input->post('flativo'),$this->input->post('texto'),$this->input->post('idempresa'))
        );
        
        if($this->input->post('flativo')){
            $this->view('cargo/lista', $data, FALSE);
        }else{
            $this->view('cargo/listar', $data);
        }
        
    }
    
    public function novo() {
        return $this->view('cargo/novo',array("empresas" => $this->empresas),FALSE);
    }
    
    public function editar($id,$idempresa) {
        $campos = ['cargo' => $this->cargo->ler($id,$idempresa)];
        return $this->view('cargo/editar',$campos,FALSE);
        
    }

    public function salvar() {
                
        $var = $this->input->post();
        unset($var['form']);
        
        if ($this->input->post('form') == "Salvar") {
            $this->cargo->update($var);
        }else {
            $this->cargo->save($var);
        }
        $this->session->set_flashdata("error", "<div class='alert alert-success' role='alert'>Registro salvo com sucesso.</div>");
        redirect('cargo');
    }
    

}
