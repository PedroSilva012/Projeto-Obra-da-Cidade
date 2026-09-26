using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using Org.BouncyCastle.Asn1.Cmp;

namespace Obrasdacidade
{
    public partial class FrmContas : Form
    {
        public FrmContas()
        {
            InitializeComponent();
        }

        private void FrmContas_Load(object sender, EventArgs e)
        {
            try
            {
                ClassConexao.Conectar();
                cmbNivel.DataSource = ClassGeral.Selecionar("select * from tab_acesso");
                cmbNivel.ValueMember = "id";
                cmbNivel.DisplayMember = "nivel";
                dataGridView1.DataSource = ClassGeral.Selecionar("select * from tab_usuarios");
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao carregar o sistema: {ex.Message}",
                    $"Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            txtUsuario.Text = dataGridView1.CurrentRow.Cells[1].Value.ToString();
            txtSenha.Text = dataGridView1.CurrentRow.Cells[2].Value.ToString();
            dtpDataCriacao.Text = dataGridView1.CurrentRow.Cells[4].Value.ToString();
            txtEmail.Text = dataGridView1.CurrentRow.Cells[5].Value.ToString();
            txtTelefone.Text = dataGridView1.CurrentRow.Cells[6].Value.ToString();
            cmbNivel.SelectedValue = Convert.ToInt32(dataGridView1.CurrentRow.Cells[3].Value.ToString());
        }

        private void btnAtualizarUsuario_Click(object sender, EventArgs e)
        {
            try
            {
                // Pega o ID da obra (supondo que você tenha em um TextBox ou já carregou em memória)
                int id = int.Parse(dataGridView1.CurrentRow.Cells[0].Value.ToString());

                string nome = txtUsuario.Text.Trim();
                string senha = txtSenha.Text.Trim();
                string email = txtEmail.Text.Trim();
                string telefone = txtTelefone.Text.Trim();

                int id_nivel = int.Parse(cmbNivel.SelectedValue.ToString());
                DateTime prazo = dtpDataCriacao.Value;

                // Validação simples
                if (string.IsNullOrEmpty(nome) || string.IsNullOrEmpty(senha) || string.IsNullOrEmpty(email))
                {
                    MessageBox.Show("Preencha todos os campos obrigatórios!");
                    return;
                }

                // Chama a função de atualização (você precisa ter isso na sua classe ClassAdicionar ou ClassObra)
                ClassAdicionar.AtualizarUsuario(id, nome, senha, prazo, email, telefone, id_nivel);

                MessageBox.Show("Usuario Atualizado Com Sucesso!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);

                // Recarrega o DataGridView
                dataGridView1.DataSource = ClassGeral.Selecionar("SELECT * FROM tab_usuarios");

            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao atualizar a obra: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnCriar_Click(object sender, EventArgs e)
        {
            try
            {
                string usuario = txtUsuario.Text.Trim();
                string senha = txtSenha.Text.Trim();
                string email = txtEmail.Text.Trim();
                string telefone = txtTelefone.Text.Trim();

                if (cmbNivel.SelectedValue == null)
                {
                    MessageBox.Show("Selecione um nível de acesso!");
                    return;
                }
                int nivelAcesso = Convert.ToInt32(cmbNivel.SelectedValue);
                DateTime dtCriacao = dtpDataCriacao.Value;

                // Validação simples
                if (string.IsNullOrEmpty(usuario) || string.IsNullOrEmpty(senha) || string.IsNullOrEmpty(email))
                {
                    MessageBox.Show("Preencha todos os campos obrigatórios!");
                    return;
                }

                // 🔹 Chama a classe de adicionar
                ClassAdicionar.Criar(usuario, senha, dtCriacao, email,telefone,nivelAcesso);

                MessageBox.Show("Usuário criado com sucesso!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);

                // Recarrega o DataGridView
                dataGridView1.DataSource = ClassGeral.Selecionar("SELECT * FROM tab_usuarios");
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao criar usuário: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }


        private void btnDeletar_Click(object sender, EventArgs e)
        {
            try
            {
                if (dataGridView1.CurrentRow == null)
                {
                    MessageBox.Show("Selecione um usuário para deletar!");
                    return;
                }

                int id = int.Parse(dataGridView1.CurrentRow.Cells[0].Value.ToString());

                var confirm = MessageBox.Show("Deseja realmente excluir este usuário?",
                                              "Confirmação",
                                              MessageBoxButtons.YesNo,
                                              MessageBoxIcon.Warning);

                if (confirm == DialogResult.Yes)
                {
                    ClassAdicionar.Deletar(id);

                    MessageBox.Show("Usuário deletado com sucesso!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Recarrega o DataGridView
                    dataGridView1.DataSource = ClassGeral.Selecionar("SELECT * FROM tab_usuarios");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao deletar usuário: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
