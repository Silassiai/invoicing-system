<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 3-12-2018
 * Time: 22:09
 */

namespace core;

class View
{
    private $controller = null;
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * load
     * Load requested template
     * extract passed array to variables
     * Ads js file to specific template if assets uri matches and file exists
     * @param string $file
     * @param array $data
     */
    public function load($file = 'pages/index', array $data = [])
    {
        if ($file === 'templates/footer') {
            $data['token'] = '<div id="token" style="display: none">' . $this->controller->getCSRFToken() . '</div>';
        }
        extract($data);
        $data = null;
        require_once SDR_PATH_VIEW . $file . '.php';
    }

    public function paginate(array $result = [], $step = 5)
    {
        $columns = array_keys($result[0]);
        $table = '<table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>';
        foreach ($columns as $column) {
            $table .= '<th>' . $column . '</th>';
        }
        $table .= '
                    </tr>
                    </thead>
                    <tbody>';
        foreach ($result as $columns) {
            $table .= '<tr>';
            foreach ($columns as $column) {
                $table .= '<td>' . $column . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tr>
                    </tbody>
                    <tfoot>
                    <tr>';
        foreach ($columns as $column) {
            $table .= '<th>' . $column . '</th>';
        }
        $table .= '</tr>
                    </tfoot>
                </table>';

        $pages = implode(', ', range(5, count($result), $step));
        $script = '<script>
                    $(document).ready(function() {
                        $(\'#example\').DataTable({
                            "lengthMenu": [[' . $pages . ', -1], [' . $pages . ', "All"]]
                        });
                    } );
                    </script>';
        return $table . PHP_EOL . $script;
    }
}
