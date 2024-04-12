<?

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Exportar
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
  }

  public function Excel()
  {
    $Api = new Api('https://localhost/easy-users/backend/api/usuarios/', "", "", "Authorization: Basic " . $_SESSION['TOKEN']);
    $response = $Api->get('listar');

    $data_response = json_decode($response);

    // print_r("<pre>");
    // print_r($data_response);
    // print_r("</pre>");

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue("A1", "id");
    $sheet->setCellValue("B1", "Nome");
    $sheet->setCellValue("C1", "Usuário");
    $sheet->setCellValue("D1", "Função");
    $sheet->setCellValue("E1", "RG");
    $sheet->setCellValue("F1", "CPF");
    $sheet->setCellValue("G1", "Rua");
    $sheet->setCellValue("H1", "Número");
    $sheet->setCellValue("I1", "Bairro");
    $sheet->setCellValue("J1", "CEP");
    $sheet->setCellValue("K1", "Cidade");
    $sheet->setCellValue("L1", "UF");
    $sheet->setCellValue("M1", "Criado em");

    $sheet->getStyle("A1:M1")->getFont()->setSize(16);
    $sheet->getStyle("A1:M1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("4478B6");
    $sheet->getStyle("A1:M1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

    $linha_inicial = 2;

    $linha = $linha_inicial;

    foreach ($data_response->data as $chave => $valor) {

      if ($linha % 2) {
        $sheet->getStyle("A" . $linha . ":M" . $linha)
          ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b7c2ea');
      } else {
        $sheet->getStyle("A" . $linha . ":M" . $linha)
          ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("dae0f3");
      }

      $sheet->setCellValue("A{$linha}", $valor->id);
      $sheet->setCellValue("B{$linha}", $valor->nome);
      $sheet->setCellValue("C{$linha}", $valor->nome_usuario);
      $sheet->setCellValue("D{$linha}", $valor->nome_funcao);
      $sheet->setCellValue("E{$linha}", $valor->rg);
      $sheet->setCellValue("F{$linha}", $valor->cpf);
      $sheet->setCellValue("G{$linha}", $valor->rua);
      $sheet->setCellValue("H{$linha}", $valor->numero);
      $sheet->setCellValue("I{$linha}", $valor->bairro);
      $sheet->setCellValue("J{$linha}", $valor->cep);
      $sheet->setCellValue("K{$linha}", $valor->cidade);
      $sheet->setCellValue("L{$linha}", $valor->uf);
      $sheet->setCellValue("M{$linha}", $valor->criado_em);

      $linha++;
    }

    $sheet->getStyle('A:M')->getAlignment()->setHorizontal('center');

    foreach ($sheet->getColumnIterator() as $column) {
      $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }

    $data_hora = date('Ymd-his');
    $nome_arquivo = "lista_usuarios-{$data_hora}.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename={$nome_arquivo}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
  }

  public function PDF()
  {

    $Api = new Api('https://localhost/easy-users/backend/api/usuarios/', "", "", "Authorization: Basic " . $_SESSION['TOKEN']);
    $response = $Api->get('listar');

    $data_response = json_decode($response);
    $html = "";
    $html .= "<style> .evolucoes td, .evolucoes th {border: solid 1px #ccc; padding:7px;} </style>";

    foreach ($data_response->data as $key => $value) {

      $html .= "<table class='evolucoes' style='width:100%; border-collapse: collapse; margin-bottom: 15px; padding:5px; page-break-inside: avoid;'>
                <tbody>
                  <tr style='background: #4478B6'> 
                    <td colspan='2' style='font-size: 1.2rem; font-weight: bold; color: #fff; text-align: center'>{$value->nome}</td>
                  </tr>
                  <tr>
                    <td style='text-align:right;margin:0;font-weight: bold;' width='100px'>Usuário</td>
                    <td style='margin:0;'>{$value->nome_usuario}</td>
                  </tr>
                  <tr>
                    <td style='text-align:right;margin:0;font-weight: bold;' width='100px'>Função</td>
                    <td style='margin:0;'>{$value->nome_funcao}</td>
                  </tr>
                  <tr>
                    <td style='text-align:right;margin:0;font-weight: bold;' width='100px'>Endereço</td>
                    <td style='margin:0;'>{$value->rua}, Nº {$value->numero}, {$value->bairro} - CEP: {$value->cep}  , {$value->cidade}/{$value->uf}</td>
                  </tr>              
                </tbody>
              </table>";
    }

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 35,
      'margin_bottom' => 35,
      'fontdata' => $fontData + [
        'freesans' => [
          'R' => 'FreeSans.ttf',
          'I' => 'FreeSansOblique.ttf',
        ],
      ],
      'default_font' => 'freesans'
    ]);
    $mpdf->use_kwt = true;

    $header = "<table style='width:100%;'>
            <tr style='width:100%;'>
              <th><img width='150px' src='https://acesso.easycourse.com.br/acesso/img/logo_min.png'></th>
            </tr>
          </table>";

    $footer = "<table style='width:100%;'>
            <tr style='width:100%;'>
              <th width='10%' style='text-align:left;'>
                <img width='150px' src='https://acesso.easycourse.com.br/acesso/img/logo_min.png'>
              </th>
              <th width='90%' style='font-size:10px; color:#434343;'>
                <span style='font-size:14px'>Easy Course</span> <br>
                <span style='font-size:12px'>XXXXXXXXXXXXX</span> <br>
                <span style='font-size:12px'>CNPJ: XXXXXXXXXXXXX</span> <br> <br>
                <span>(XX) XXXX-XXXX - (XX) 9XXXX-XXXX</span><br>
              </th>
            </tr>
          </table>";


    $mpdf->SetHTMLHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->SetWatermarkImage('https://acesso.easycourse.com.br/acesso/img/logo_min.png', 0.1);
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }
}
