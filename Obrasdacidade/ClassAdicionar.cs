using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace Obrasdacidade
{
    internal class ClassAdicionar
    {
        public static void Inserir(string nome, string descricao, DateTime prazo, string localizacao, string imagem, int id_status)
        {
            ClassConexao.Conectar();
            string sql = "INSERT INTO tab_obras(nome, descricao, prazo, localizacao,imagem,id_status) VALUES(@nome,@descricao,@prazo,@localizacao,@imagem,@id_status)";
            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            cmd.Parameters.AddWithValue("nome", nome);
            cmd.Parameters.AddWithValue("descricao", descricao);
            cmd.Parameters.AddWithValue("prazo", prazo);
            cmd.Parameters.AddWithValue("localizacao", localizacao);
            cmd.Parameters.AddWithValue("imagem", imagem);
            cmd.Parameters.AddWithValue("id_status", id_status);
            cmd.ExecuteNonQuery();
            ClassConexao.Desconectar();

        }

        public static void Atualizar(int id, string nome, string descricao, DateTime prazo, string localizacao, string imagem, int id_status)
        {
            ClassConexao.Conectar();
            string sql = "UPDATE tab_obras SET nome = @nome, descricao = @descricao, prazo = @prazo, localizacao = @localizacao, imagem = @imagem, id_status = @id_status WHERE id = @id";

            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            {
                cmd.Parameters.AddWithValue("@id", id);
                cmd.Parameters.AddWithValue("@nome", nome);
                cmd.Parameters.AddWithValue("@descricao", descricao);
                cmd.Parameters.AddWithValue("@prazo", prazo);
                cmd.Parameters.AddWithValue("@localizacao", localizacao);
                cmd.Parameters.AddWithValue("@imagem", imagem);
                cmd.Parameters.AddWithValue("@id_status", id_status);

                cmd.ExecuteNonQuery();
            }
        }

        public static void Criar(string usuario, string senha, DateTime dataCriacao, string email, string telefone, int idNivel)
        {
            ClassConexao.Conectar();
            string sql = "INSERT INTO tab_usuarios (usuario, senha, nivel_acesso, dt_criacao, email, telefone) " +
                         "VALUES (@usuario, @senha, @nivel_acesso, @dt_criacao, @email, @telefone)";

            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            {
                cmd.Parameters.AddWithValue("@usuario", usuario);
                cmd.Parameters.AddWithValue("@senha", senha);
                cmd.Parameters.AddWithValue("@nivel_acesso", idNivel);
                cmd.Parameters.AddWithValue("@dt_criacao", dataCriacao);
                cmd.Parameters.AddWithValue("@email", email);
                cmd.Parameters.AddWithValue("@telefone", telefone);

                cmd.ExecuteNonQuery();
            }
        }

        public static void AtualizarUsuario(int id, string usuario, string senha, DateTime dtCriacao, string email, string telefone, int nivelAcesso)
        {
            ClassConexao.Conectar();
            string sql = "UPDATE tab_usuarios SET usuario=@usuario, senha=@senha, nivel_acesso=@nivel, dt_criacao=@dtCriacao, " +
                         "email=@email, telefone=@telefone WHERE id=@id";

            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            {
                cmd.Parameters.AddWithValue("@usuario", usuario);
                cmd.Parameters.AddWithValue("@senha", senha);
                cmd.Parameters.AddWithValue("@nivel", nivelAcesso);
                cmd.Parameters.AddWithValue("@dtCriacao", dtCriacao);
                cmd.Parameters.AddWithValue("@email", email);
                cmd.Parameters.AddWithValue("@telefone", telefone);
                cmd.Parameters.AddWithValue("@id", id);

                cmd.ExecuteNonQuery();
            }
        }
        
        public static void Deletar(int id)
        {
            ClassConexao.Conectar();
            string sql = "DELETE FROM tab_usuarios WHERE id = @id";

            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
            {
                cmd.Parameters.AddWithValue("@id", id);
                cmd.ExecuteNonQuery();
            }
        }

    }
}

