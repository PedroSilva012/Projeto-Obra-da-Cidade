using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace Obrasdacidade
{
    internal class ClassConexao
    {
        public static MySqlConnection conn;
        private static string conexao = "Server=localhost;Database=obrasdacidade;Uid=root;Pwd=";


        public static void Conectar()
        {
            conn = new MySqlConnection(conexao);
            conn.Open();
        }

        public static void Desconectar()
        {
            conn.Close();
        }
    }
}
