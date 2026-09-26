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
using Mysqlx.Crud;

namespace Obrasdacidade
{
    public partial class FrmInserir : Form
    {
        private byte[] imagemBytes;
        public FrmInserir()
        {
            InitializeComponent();
        }

        private void FrmInserir_Load(object sender, EventArgs e)
        {
            try
            {
                ClassConexao.Conectar();
                cmbStatus.DataSource = ClassGeral.Selecionar("select * from tab_status");
                cmbStatus.ValueMember = "id_status";
                cmbStatus.DisplayMember = "status";
            }
            catch(Exception ex) 
            {
                MessageBox.Show($"Erro ao carregar o sistema: {ex.Message}",
                    $"Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            
        }

        private void btnInserir_Click(object sender, EventArgs e)
        {
            try
            {
                string nome = txtNome.Text.Trim();
                string descricao = txtDescricao.Text.Trim();
                string localizacao = txtLocalizacao.Text.Trim();
                string imagem = txtImagem.Text.Trim();

                // Pega o status selecionado
                int id_status = int.Parse(cmbStatus.SelectedValue.ToString());
                DateTime prazo = DateTime.Now;

                // Validação com IF (exemplo: não permitir salvar vazio)
                if (string.IsNullOrEmpty(nome) || string.IsNullOrEmpty(descricao) || string.IsNullOrEmpty(localizacao))
                {
                    MessageBox.Show("Preencha todos os campos obrigatórios!");
                    return; // sai do método sem tentar salvar
                }

                // Se passou da validação, tenta inserir
                ClassAdicionar.Inserir(nome, descricao, prazo, localizacao, imagem, id_status);

                MessageBox.Show("Obra adicionada ao banco com sucesso!");
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao adicionar a obra ao banco de dados: {ex.Message}");
            }
        }


        private void btnEscolherImagem_Click(object sender, EventArgs e)
        {
            //OpenFileDialog openFileDialog = new OpenFileDialog();
            //openFileDialog.Filter = "Imagens|*.jpg;*.jpeg;*.png;*.bmp;"; // Filtro para tipos de imagem

            //if (openFileDialog.ShowDialog() == DialogResult.OK)
            //{
            //    // Lê os bytes da imagem selecionada
            //    imagemBytes = File.ReadAllBytes(openFileDialog.FileName);

            //    // Exibe a imagem no PictureBox
            //    using (MemoryStream ms = new MemoryStream(imagemBytes))
            //    {
            //        pictureBox1.Image = System.Drawing.Image.FromStream(ms);
            //    }
            //}
            var fileContent = string.Empty;
            var filePath = string.Empty;

            using (OpenFileDialog openFileDialoge = new OpenFileDialog())
            {
                openFileDialoge.InitialDirectory = "c:\\";
                openFileDialoge.Filter = "Imagens|*.jpg;*.jpeg;*.png;*.bmp;";
                //openFileDialoge.FilterIndex = 2;
                openFileDialoge.RestoreDirectory = true;

                if (openFileDialoge.ShowDialog() == DialogResult.OK)
                {
                    //Get the path of specified file
                    filePath = openFileDialoge.FileName;

                    imagemBytes = File.ReadAllBytes(openFileDialoge.FileName);

                    using (MemoryStream ms = new MemoryStream(imagemBytes))
                    {
                        pictureBox1.Image = System.Drawing.Image.FromStream(ms);
                    }

                    string pasta = System.Environment.CurrentDirectory + "\\imagens\\";

                    File.Copy(filePath, pasta + Path.GetFileName(openFileDialoge.FileName));
                    //Read the contents of the file into a stream
                    //var fileStream = openFileDialoge.OpenFile();
                    txtImagem.Text = Path.GetFileName(openFileDialoge.FileName);

                    //using (StreamReader reader = new StreamReader(fileStream))
                    //{
                    //    fileContent = reader.ReadToEnd();
                    //}
                }
         }
       }
     }
   }

