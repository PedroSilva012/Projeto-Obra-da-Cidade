using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace Obrasdacidade
{
    internal class ClassGeral
    {
        public static DataTable Selecionar(string sql)
        {
            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            DataTable dt = new DataTable();
            dt.Load(cmd.ExecuteReader());
            return dt;
        }
    }
}
