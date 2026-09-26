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
    public partial class FrmMenu : Form
    {
        private Button btnAtual;

        private Form formAtual;

        public FrmMenu()
        {
            InitializeComponent();
        }

        private void SelecionarBTN(object btnsender)
        {
            if (btnsender != null)
            {
                if (btnsender != btnAtual)
                {
                    ResetarBTNs();
                    btnAtual = (Button)btnsender;
                    btnAtual.BackColor = System.Drawing.SystemColors.GradientActiveCaption;
                    btnAtual.Font = new System.Drawing.Font("Microsoft Sans Serif", 8, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
                }
            }
        }

        private void SelecionarForm(Form form, object btnsender)
        {
            if (formAtual != null)
            {
                formAtual.Close();
            }

            SelecionarBTN(btnsender);
            formAtual = form;

            form.TopLevel = false;
            form.FormBorderStyle = FormBorderStyle.None;
            form.Dock = DockStyle.Fill;
            this.panel3.Controls.Add(form);
            this.panel3.Tag = false;
            form.BringToFront();
            form.Show();

        }

        private void ResetarBTNs()
        {
            foreach (Control itenControl in panel1.Controls)
            {
                if (itenControl.GetType() == typeof(Button))
                {

                    itenControl.BackColor = System.Drawing.SystemColors.Highlight;
                    itenControl.Font = new System.Drawing.Font("Microsoft Sans Serif", 8, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
                    btnAtual = null;
                }
            }
        }

        private void DesativarBTNs()
        {
            foreach(Control itenControl in panel2.Controls)
            {
                if(itenControl.GetType() == typeof(Button))
                {
                   
                }
            }
        }

        private void btnEditarObra_Click(object sender, EventArgs e)
        {
            SelecionarForm(new FrmEditar(), sender);
        }

        private void FrmMenu_Load(object sender, EventArgs e)
        {
            // Mostra os dados do usuário logado
            lblUsuarioMenu.Text = $"Bem-vindo, {ClassSessao.Usuario}";
            lblEmailMenu.Text = $"Email: {ClassSessao.Email}";
        }

        private void btnUsuarios_Click(object sender, EventArgs e)
        {
            SelecionarForm(new FrmContas(), sender);
        }

        private void btnInserirObra_Click(object sender, EventArgs e)
        {
            SelecionarForm(new FrmInserir(), sender);
        }
        
        private void btnObras_Click(object sender, EventArgs e)
        {
            SelecionarForm(new FrmObras(), sender);
        }

        private void btnInicio_Click(object sender, EventArgs e)
        {
            DesativarBTNs();
            formAtual?.Close();
        }

        private void btnPedidos_Click(object sender, EventArgs e)
        {
            SelecionarForm(new FrmPedidos(), sender);
        }
    }
}
