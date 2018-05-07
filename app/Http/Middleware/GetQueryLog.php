<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class GetQueryLog
{

        /**
       * Costruisce l'html delle query
       * 
       * @access private
       * @static
       * @param object $queryLog
       * @return string $query
       */
       
      private static function _queryLog ($queries) {
        
        $query = "";
        $count = 1;

        /**
         * Ciclo su tutto l'oggetto 
         */
        foreach ($queries as $q):

          if ($count < 10)
            $query .= '<span style="color:#888; font-size:12px;display:inline-block; padding:2px 5px; margin-bottom:1px; ">0' . $count . '</span>&nbsp;';
          else
            $query .= '<span style="color:#888; font-size:12px; display:inline-block; padding:2px 5px; margin-bottom:1px; ">' . $count . '</span>&nbsp;';

          $qu = explode("?", $q["query"]);
          $newquery = "";
          $cc = 0;
          
          /**
           * Aggiungo i parametri
           */
           
          if (is_array($qu)) {
            foreach ($qu as $newq):

              $newquery .= $newq;

            if (isset($q["bindings"][$cc]))
              $newquery .= "'" . $q["bindings"][$cc] . "'";

            $cc++;

            endforeach;
            
          } else {
            
            $newquery =  $q["query"];
            
          }
          
          
          $query .= $newquery . '<br/>';
          $count++;
          endforeach;

        return  $query;
            
      }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
      {   
          DB::enableQueryLog();
          return $next($request);
      }


    public function terminate($request, $response)
      {
         $queries = DB::getQueryLog();

         $queries_cont  = '<a href="#" onclick="changeTab(\'query_log\')" style="color:#1fb0e1"><strong>' . count($queries)  . '</strong> query eseguite</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
         $queries_html  = '<span id="query_log" style="height:500px; padding:15px; overflow:scroll; ">' . $this->_queryLog($queries) . '</span>';

         echo '<div id="report_debug" style=" line-height:1.5em; font-size:16px; z-index:100000; border-top:1px solid #FFF; background:#444;  color:#fff; bottom:0; left:0; right:0;  display:block;">' .
           '<span style="display:block; padding:15px;  background:#333;">' .
           $queries_cont .
            '</span>' . 
            '<span style="display:block; ">' .
               $queries_html .
             '</span>' .
           '</div>';
      }
}
