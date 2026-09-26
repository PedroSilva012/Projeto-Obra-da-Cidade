using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Obrasdacidade
{
    internal static class Program
    {
        /// <summary>
        /// Ponto de entrada principal para o aplicativo.
        /// </summary>
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            string pasta = System.Environment.CurrentDirectory + "\\imagens\\";
            if (!Directory.Exists(pasta))
            {
                Directory.CreateDirectory(pasta);
            }
            Application.Run(new FrmLogin());
        }
    }
}
