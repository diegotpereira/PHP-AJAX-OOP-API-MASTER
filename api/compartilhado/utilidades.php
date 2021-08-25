<?php 

class Utilidades{
    public function obterPaginacao($page, $total_linhas, $registros_por_pagina, $pagina_url)
    {
        // matriz de paginação
        $paging_arr = array();

        // botão para a primeira página
        $paging_arr["first"] = $page > 1 ? "{$pagina_url}page=1" : "";

        // conte todos os produtos no banco de dados para calcular o total de páginas
        $total_paginas = ceil($total_linhas / $registros_por_pagina);

        // range de links para mostrar
        $range = 2;

        //exibir links para 'intervalo de páginas' em torno da 'página atual'
        $inicial_num = $page - $range;
        $condicao_limit_num = ($page + $range) + 1;

        $paging_arr['pages'] = array();
        $contar_pagina = 0;

        for ($x=$inicial_num; $x < $condicao_limit_num ; $x++) { 
            # code...
            // certifique-se de que '$ x é maior que 0' E 'menor ou igual a $ total_paginas
            if (($x > 0) && ($x <= $total_paginas)) {
                # code...
                $paging_arr['pages'][$contar_pagina]["page"] = $x;
                $paging_arr['pages'][$contar_pagina]["url"] = "{$pagina_url}page={$x}";
                $paging_arr['pages'][$contar_pagina]["pagina_atual"] = $x==$page ? "sim" : "não";

                $contar_pagina++;
            }
        }

        // botão para última página
        $paging_arr["last"] = $page < $total_paginas ? "{$pagina_url}page={$total_paginas}" : "";

        //formato json
        return $paging_arr;
    }
}
?>