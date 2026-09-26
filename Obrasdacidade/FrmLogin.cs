using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using MySqlX.XDevAPI;

namespace Obrasdacidade
{
    public partial class FrmLogin : Form
    {
        public FrmLogin()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            string usuario, senha;
            usuario = txtUsuario.Text;
            senha = txtSenha.Text;

            if(usuario.Length >= 3 && senha.Length >= 3)
            {
                ClassConexao.Conectar();
                string sql = $"select * from tab_usuarios where usuario='{usuario}' and senha='{senha}'";
                MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
                DataTable dt = new DataTable();
                dt.Load(cmd.ExecuteReader());
                if (dt.Rows.Count > 0)
                {
                    // Login válido
                    MessageBox.Show("Login realizado com sucesso!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Pega dados do usuário (ex: nível de acesso)
                    string nivel = dt.Rows[0]["nivel_acesso"].ToString();
                    ClassSessao.Usuario = dt.Rows[0]["usuario"].ToString();
                    ClassSessao.Email = dt.Rows[0]["email"].ToString();
                    ClassSessao.Id = Convert.ToInt32(dt.Rows[0]["id"]);


                    // Abre o form principal
                    FrmMenu form = new FrmMenu();
                    form.Show();

                    this.Hide(); // esconde o form de login
                }
                else
                {
                    MessageBox.Show("Usuario ou a senha ta errado", "Erro ao Logar", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }

            }
            else
            {
                MessageBox.Show("Escreva a Senha Corretamente", "Erro ao Logar", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }



        }

        private void btnSair_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }

        private void FrmLogin_Load(object sender, EventArgs e)
        {

        }
    }
}
