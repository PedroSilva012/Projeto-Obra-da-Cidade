namespace Obrasdacidade
{
    partial class FrmMenu
    {
        /// <summary>
        /// Variável de designer necessária.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Limpar os recursos que estão sendo usados.
        /// </summary>
        /// <param name="disposing">true se for necessário descartar os recursos gerenciados; caso contrário, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Código gerado pelo Windows Form Designer

        /// <summary>
        /// Método necessário para suporte ao Designer - não modifique 
        /// o conteúdo deste método com o editor de código.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FrmMenu));
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnUsuarios = new System.Windows.Forms.Button();
            this.btnEditarObra = new System.Windows.Forms.Button();
            this.btnInserirObra = new System.Windows.Forms.Button();
            this.btnObras = new System.Windows.Forms.Button();
            this.btnInicio = new System.Windows.Forms.Button();
            this.lblEmailMenu = new System.Windows.Forms.Label();
            this.lblUsuarioMenu = new System.Windows.Forms.Label();
            this.panel2 = new System.Windows.Forms.Panel();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.panel3 = new System.Windows.Forms.Panel();
            this.btnPedidos = new System.Windows.Forms.Button();
            this.panel1.SuspendLayout();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.panel3.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel1
            // 
            this.panel1.BackColor = System.Drawing.SystemColors.Highlight;
            this.panel1.Controls.Add(this.btnPedidos);
            this.panel1.Controls.Add(this.btnUsuarios);
            this.panel1.Controls.Add(this.btnEditarObra);
            this.panel1.Controls.Add(this.btnInserirObra);
            this.panel1.Controls.Add(this.btnObras);
            this.panel1.Controls.Add(this.btnInicio);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Right;
            this.panel1.Location = new System.Drawing.Point(1762, 0);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(140, 721);
            this.panel1.TabIndex = 0;
            // 
            // btnUsuarios
            // 
            this.btnUsuarios.BackColor = System.Drawing.SystemColors.Highlight;
            this.btnUsuarios.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnUsuarios.ForeColor = System.Drawing.Color.White;
            this.btnUsuarios.Location = new System.Drawing.Point(0, 228);
            this.btnUsuarios.Name = "btnUsuarios";
            this.btnUsuarios.Size = new System.Drawing.Size(140, 56);
            this.btnUsuarios.TabIndex = 6;
            this.btnUsuarios.Text = "Usuarios";
            this.btnUsuarios.UseVisualStyleBackColor = false;
            this.btnUsuarios.Click += new System.EventHandler(this.btnUsuarios_Click);
            // 
            // btnEditarObra
            // 
            this.btnEditarObra.BackColor = System.Drawing.SystemColors.Highlight;
            this.btnEditarObra.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnEditarObra.ForeColor = System.Drawing.Color.White;
            this.btnEditarObra.Location = new System.Drawing.Point(0, 175);
            this.btnEditarObra.Name = "btnEditarObra";
            this.btnEditarObra.Size = new System.Drawing.Size(140, 56);
            this.btnEditarObra.TabIndex = 5;
            this.btnEditarObra.Text = "Editar Obra";
            this.btnEditarObra.UseVisualStyleBackColor = false;
            this.btnEditarObra.Click += new System.EventHandler(this.btnEditarObra_Click);
            // 
            // btnInserirObra
            // 
            this.btnInserirObra.BackColor = System.Drawing.SystemColors.Highlight;
            this.btnInserirObra.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnInserirObra.ForeColor = System.Drawing.Color.White;
            this.btnInserirObra.Location = new System.Drawing.Point(0, 122);
            this.btnInserirObra.Name = "btnInserirObra";
            this.btnInserirObra.Size = new System.Drawing.Size(140, 56);
            this.btnInserirObra.TabIndex = 4;
            this.btnInserirObra.Text = "Inserir Obra";
            this.btnInserirObra.UseVisualStyleBackColor = false;
            this.btnInserirObra.Click += new System.EventHandler(this.btnInserirObra_Click);
            // 
            // btnObras
            // 
            this.btnObras.BackColor = System.Drawing.SystemColors.Highlight;
            this.btnObras.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnObras.Font = new System.Drawing.Font("Microsoft Sans Serif", 7.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnObras.ForeColor = System.Drawing.Color.White;
            this.btnObras.Location = new System.Drawing.Point(0, 69);
            this.btnObras.Name = "btnObras";
            this.btnObras.Size = new System.Drawing.Size(140, 56);
            this.btnObras.TabIndex = 3;
            this.btnObras.Text = "Obras";
            this.btnObras.UseVisualStyleBackColor = false;
            this.btnObras.Click += new System.EventHandler(this.btnObras_Click);
            // 
            // btnInicio
            // 
            this.btnInicio.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnInicio.ForeColor = System.Drawing.Color.White;
            this.btnInicio.Image = ((System.Drawing.Image)(resources.GetObject("btnInicio.Image")));
            this.btnInicio.Location = new System.Drawing.Point(0, -8);
            this.btnInicio.Name = "btnInicio";
            this.btnInicio.Size = new System.Drawing.Size(140, 81);
            this.btnInicio.TabIndex = 0;
            this.btnInicio.UseVisualStyleBackColor = true;
            this.btnInicio.Click += new System.EventHandler(this.btnInicio_Click);
            // 
            // lblEmailMenu
            // 
            this.lblEmailMenu.AutoSize = true;
            this.lblEmailMenu.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblEmailMenu.Location = new System.Drawing.Point(53, 192);
            this.lblEmailMenu.Name = "lblEmailMenu";
            this.lblEmailMenu.Size = new System.Drawing.Size(74, 29);
            this.lblEmailMenu.TabIndex = 8;
            this.lblEmailMenu.Text = "Email";
            // 
            // lblUsuarioMenu
            // 
            this.lblUsuarioMenu.AutoSize = true;
            this.lblUsuarioMenu.Font = new System.Drawing.Font("Microsoft Sans Serif", 13.8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblUsuarioMenu.Location = new System.Drawing.Point(53, 146);
            this.lblUsuarioMenu.Name = "lblUsuarioMenu";
            this.lblUsuarioMenu.Size = new System.Drawing.Size(79, 29);
            this.lblUsuarioMenu.TabIndex = 6;
            this.lblUsuarioMenu.Text = "Nome";
            // 
            // panel2
            // 
            this.panel2.BackColor = System.Drawing.SystemColors.Highlight;
            this.panel2.Controls.Add(this.pictureBox1);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(1762, 69);
            this.panel2.TabIndex = 1;
            // 
            // pictureBox1
            // 
            this.pictureBox1.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox1.Image")));
            this.pictureBox1.Location = new System.Drawing.Point(21, 12);
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size(62, 54);
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pictureBox1.TabIndex = 0;
            this.pictureBox1.TabStop = false;
            // 
            // panel3
            // 
            this.panel3.BackColor = System.Drawing.SystemColors.Window;
            this.panel3.Controls.Add(this.lblEmailMenu);
            this.panel3.Controls.Add(this.lblUsuarioMenu);
            this.panel3.Dock = System.Windows.Forms.DockStyle.Fill;
            this.panel3.Location = new System.Drawing.Point(0, 69);
            this.panel3.Name = "panel3";
            this.panel3.Size = new System.Drawing.Size(1762, 652);
            this.panel3.TabIndex = 2;
            // 
            // btnPedidos
            // 
            this.btnPedidos.BackColor = System.Drawing.SystemColors.Highlight;
            this.btnPedidos.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnPedidos.ForeColor = System.Drawing.Color.White;
            this.btnPedidos.Location = new System.Drawing.Point(0, 281);
            this.btnPedidos.Name = "btnPedidos";
            this.btnPedidos.Size = new System.Drawing.Size(140, 56);
            this.btnPedidos.TabIndex = 7;
            this.btnPedidos.Text = "Pedidos";
            this.btnPedidos.UseVisualStyleBackColor = false;
            this.btnPedidos.Click += new System.EventHandler(this.btnPedidos_Click);
            // 
            // FrmMenu
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.SystemColors.Control;
            this.ClientSize = new System.Drawing.Size(1902, 721);
            this.Controls.Add(this.panel3);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FrmMenu";
            this.Text = "Tela Principal";
            this.WindowState = System.Windows.Forms.FormWindowState.Maximized;
            this.Load += new System.EventHandler(this.FrmMenu_Load);
            this.panel1.ResumeLayout(false);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.panel3.ResumeLayout(false);
            this.panel3.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button btnInicio;
        private System.Windows.Forms.Button btnObras;
        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.Button btnInserirObra;
        private System.Windows.Forms.Panel panel3;
        private System.Windows.Forms.Button btnEditarObra;
        private System.Windows.Forms.Label lblUsuarioMenu;
        private System.Windows.Forms.Label lblEmailMenu;
        private System.Windows.Forms.Button btnUsuarios;
        private System.Windows.Forms.Button btnPedidos;
    }
}

