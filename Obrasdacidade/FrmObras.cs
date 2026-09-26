using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Obrasdacidade
{
    public partial class FrmObras : Form
    {
        public FrmObras()
        {
            InitializeComponent();
        }

        private void FrmObras_Load(object sender, EventArgs e)
        {
            try
            {
                ClassConexao.Conectar();
                dataGridView1.DataSource = ClassGeral.Selecionar("SELECT * FROM tab_obras");

            }
            catch (Exception ex)
            {
                MessageBox.Show($"Erro ao Carregar o Sistema:  {ex.Message}!!!", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }

        }
    }
}
