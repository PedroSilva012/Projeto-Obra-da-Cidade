using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Security.Policy;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Obrasdacidade
{
    public partial class FrmEditar : Form
    {
        public FrmEditar()
        {
            InitializeComponent();
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            txtNome.Text = dataGridView1.CurrentRow.Cells[1].Value.ToString();
            txtDescricao.Text = dataGridView1.CurrentRow.Cells[2].Value.ToString();
            dtpPrazo.Text = dataGridView1.CurrentRow.Cells[3].Value.ToString();
            txtLocalizacao.Text = dataGridView1.CurrentRow.Cells[4].Value.ToString();

            txtImagem.Text = dataGridView1.CurrentRow.Cells[5].Value.ToString(); 

            string caminhoImagem = Path.Combine(Environment.CurrentDirectory, "imagens", dataGridView1.CurrentRow.Cells[5].Value.ToString());
            if (File.Exists(caminhoImagem))
            {
                pictureBox1.Image = Image.FromFile(caminhoImagem);
            }
            else
            {
                pictureBox1.Image = null; // ou uma imagem padrão
            }
            cmbStatus.SelectedValue = Convert.ToInt32(dataGridView1.CurrentRow.Cells[6].Value.ToString());

        }
        
        private void FrmEditar_Load(object sender, EventArgs e)
        {
            try
            {
                ClassConexao.Conectar();
                cmbStatus.DataSource = ClassGeral.Selecionar("select * from tab_status");
                cmbStatus.ValueMember = "id_status";
                cmbStatus.DisplayMember = "status";
                dataGridView1.DataSource = ClassGeral.Selecionar("select * from tab_obras");
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao carregar o sistema: {ex.Message}",
                    $"Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnAtualizar_Click(object sender, EventArgs e)
        {
            try
            {
                // Pega o ID da obra (supondo que você tenha em um TextBox ou já carregou em memória)
                int id = int.Parse(dataGridView1.CurrentRow.Cells[0].Value.ToString());

                string nome = txtNome.Text.Trim();
                string descricao = txtDescricao.Text.Trim();
                string localizacao = txtLocalizacao.Text.Trim();
                string imagem = txtImagem.Text.Trim();

                int id_status = int.Parse(cmbStatus.SelectedValue.ToString());
                DateTime prazo = dtpPrazo.Value;

                // Validação simples
                if (string.IsNullOrEmpty(nome) || string.IsNullOrEmpty(descricao) || string.IsNullOrEmpty(localizacao))
                {
                    MessageBox.Show("Preencha todos os campos obrigatórios!");
                    return;
                }

                // Chama a função de atualização (você precisa ter isso na sua classe ClassAdicionar ou ClassObra)
                ClassAdicionar.Atualizar(id, nome, descricao, prazo, localizacao, imagem, id_status);

                MessageBox.Show("Obra atualizada com sucesso!", "Sucesso", MessageBoxButtons.OK, MessageBoxIcon.Information);

                // Recarrega o DataGridView
                dataGridView1.DataSource = ClassGeral.Selecionar("SELECT * FROM tab_obras");

            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao atualizar a obra: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

    }
}
