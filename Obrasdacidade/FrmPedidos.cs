using System;
using System.Data;
using System.Windows.Forms;
using MySql.Data.MySqlClient;

namespace Obrasdacidade
{
    public partial class FrmPedidos : Form
    {
        public FrmPedidos()
        {
            InitializeComponent();
        }

        private void FrmPedidos_Load(object sender, EventArgs e)
        {
            CarregarPedidos();
        }
        private void CarregarPedidos()
        {
            try
            {
                ClassConexao.Conectar();
                // A consulta voltou a ser fixa, buscando apenas pedidos com status 'pendente'
                string sql = "SELECT id, id_usuario, id_obra,tipo_pedido, novo_nome, nova_descricao, nova_imagem, status FROM tab_pedidos WHERE status = 'pendente'";
                MySqlDataAdapter da = new MySqlDataAdapter(sql, ClassConexao.conn);

                DataTable dt = new DataTable();
                da.Fill(dt);
                dataGridView1.DataSource = dt;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erro ao carregar pedidos: " + ex.Message);
            }
            finally
            {
                ClassConexao.Desconectar();
            }
        }
        private void btnAprovar_Click(object sender, EventArgs e)
        {
            if (dataGridView1.SelectedRows.Count == 0)
            {
                MessageBox.Show("Por favor, selecione um pedido para aprovar.");
                return;
            }

            int pedidoId = Convert.ToInt32(dataGridView1.SelectedRows[0].Cells["id"].Value);

            MySqlTransaction trans = null;
            try
            {
                ClassConexao.Conectar();
                trans = ClassConexao.conn.BeginTransaction();

                string sqlBusca = "SELECT * FROM tab_pedidos WHERE id = @id";
                MySqlCommand cmdBusca = new MySqlCommand(sqlBusca, ClassConexao.conn, trans);
                cmdBusca.Parameters.AddWithValue("@id", pedidoId);

                MySqlDataReader reader = cmdBusca.ExecuteReader();
                if (!reader.Read())
                {
                    throw new Exception("Pedido não encontrado.");
                }

                string tipoPedido = reader.GetString("tipo_pedido");
                string novoNome = reader.IsDBNull(reader.GetOrdinal("novo_nome")) ? null : reader.GetString("novo_nome");
                string novaDescricao = reader.IsDBNull(reader.GetOrdinal("nova_descricao")) ? null : reader.GetString("nova_descricao");
                DateTime? novoPrazo = reader.IsDBNull(reader.GetOrdinal("novo_prazo")) ? (DateTime?)null : reader.GetDateTime("novo_prazo");
                string novaLocalizacao = reader.IsDBNull(reader.GetOrdinal("nova_localizacao")) ? null : reader.GetString("nova_localizacao");
                string novaImagem = reader.IsDBNull(reader.GetOrdinal("nova_imagem")) ? null : reader.GetString("nova_imagem");
                int? idStatus = reader.IsDBNull(reader.GetOrdinal("id_status")) ? (int?)null : reader.GetInt32("id_status");

                reader.Close();

                // =====================================================================================
                // NOVA VALIDAÇÃO DE IMAGEM DUPLICADA (Adicionada aqui)
                // =====================================================================================
                if (!string.IsNullOrWhiteSpace(novaImagem)) // Só verifica se uma nova imagem foi informada
                {
                    int? idObraAtual = null;
                    if (tipoPedido == "editar")
                    {
                        idObraAtual = Convert.ToInt32(dataGridView1.SelectedRows[0].Cells["id_obra"].Value);
                    }

                    if (ImagemEstaDuplicada(novaImagem, idObraAtual, trans))
                    {
                        throw new Exception($"O nome de arquivo de imagem '{novaImagem}' já está sendo utilizado por outra obra.");
                    }
                }
                // =====================================================================================

                if (tipoPedido == "editar")
                {
                    int obraId = Convert.ToInt32(dataGridView1.SelectedRows[0].Cells["id_obra"].Value);

                    string sqlAcao = @"UPDATE tab_obras SET
                                   nome = COALESCE(@nome, nome),
                                   descricao = COALESCE(@descricao, descricao),
                                   prazo = COALESCE(@prazo, prazo),
                                   localizacao = COALESCE(@localizacao, localizacao),
                                   imagem = COALESCE(@imagem, imagem),
                                   id_status = COALESCE(@id_status, id_status)
                               WHERE id = @id_obra";

                    MySqlCommand cmdAcao = new MySqlCommand(sqlAcao, ClassConexao.conn, trans);

                    cmdAcao.Parameters.AddWithValue("@nome", string.IsNullOrWhiteSpace(novoNome) ? (object)DBNull.Value : novoNome);
                    cmdAcao.Parameters.AddWithValue("@descricao", string.IsNullOrWhiteSpace(novaDescricao) ? (object)DBNull.Value : novaDescricao);
                    cmdAcao.Parameters.AddWithValue("@prazo", novoPrazo);
                    cmdAcao.Parameters.AddWithValue("@localizacao", string.IsNullOrWhiteSpace(novaLocalizacao) ? (object)DBNull.Value : novaLocalizacao);
                    cmdAcao.Parameters.AddWithValue("@imagem", string.IsNullOrWhiteSpace(novaImagem) ? (object)DBNull.Value : novaImagem);
                    cmdAcao.Parameters.AddWithValue("@id_status", idStatus);
                    cmdAcao.Parameters.AddWithValue("@id_obra", obraId);

                    int linhasAfetadas = cmdAcao.ExecuteNonQuery();
                    if (linhasAfetadas == 0)
                    {
                        throw new Exception("A obra original não foi encontrada. Ela pode ter sido apagada.");
                    }
                }
                else if (tipoPedido == "apagar")
                {
                    // --- INÍCIO DA ADIÇÃO ---
                    DialogResult confirmacao = MessageBox.Show(
                        "Tem certeza que deseja aprovar a EXCLUSÃO PERMANENTE desta obra?\n\nEsta ação não pode ser desfeita.",
                        "Confirmação de Exclusão",
                        MessageBoxButtons.YesNo,
                        MessageBoxIcon.Warning);

                    if (confirmacao == DialogResult.No)
                    {
                        // Se o admin clicar em "Não", a aprovação é cancelada e nada acontece.
                        // Usamos return para sair do método sem fazer commit da transação ou alterar o status.
                        // É importante que o Rollback seja chamado no catch/finally.
                        // Para simplificar, vamos apenas informar e deixar o pedido como pendente.
                        MessageBox.Show("Aprovação cancelada pelo usuário.", "Cancelado", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        return;
                    }
                    // --- FIM DA ADIÇÃO ---

                    int obraId = Convert.ToInt32(dataGridView1.SelectedRows[0].Cells["id_obra"].Value);

                    string sqlAcao = "DELETE FROM tab_obras WHERE id = @id_obra";
                    MySqlCommand cmdAcao = new MySqlCommand(sqlAcao, ClassConexao.conn, trans);
                    cmdAcao.Parameters.AddWithValue("@id_obra", obraId);

                    int linhasAfetadas = cmdAcao.ExecuteNonQuery();
                    if (linhasAfetadas == 0)
                    {
                        throw new Exception("A obra a ser apagada não foi encontrada. Ela pode já ter sido removida.");
                    }
                }
                else if (tipoPedido == "criar")
                {
                    string sqlAcao = @"INSERT INTO tab_obras (nome, descricao, prazo, localizacao, imagem, id_status)
                             VALUES (@nome, @descricao, @prazo, @localizacao, @imagem, @id_status)";
                    MySqlCommand cmdAcao = new MySqlCommand(sqlAcao, ClassConexao.conn, trans);
                    cmdAcao.Parameters.AddWithValue("@nome", novoNome);
                    cmdAcao.Parameters.AddWithValue("@descricao", novaDescricao);
                    cmdAcao.Parameters.AddWithValue("@prazo", novoPrazo);
                    cmdAcao.Parameters.AddWithValue("@localizacao", novaLocalizacao);
                    cmdAcao.Parameters.AddWithValue("@imagem", novaImagem);
                    cmdAcao.Parameters.AddWithValue("@id_status", idStatus ?? 2);
                    cmdAcao.ExecuteNonQuery();
                }

                string sqlStatus = "UPDATE tab_pedidos SET status = 'aprovado' WHERE id = @id AND status = 'pendente'";
                MySqlCommand cmdStatus = new MySqlCommand(sqlStatus, ClassConexao.conn, trans);
                cmdStatus.Parameters.AddWithValue("@id", pedidoId);
                int statusRows = cmdStatus.ExecuteNonQuery();

                if (statusRows == 0)
                {
                    throw new Exception("Este pedido já foi processado por outro administrador.");
                }

                trans.Commit();
                MessageBox.Show("Pedido aprovado e ação executada com sucesso!");
            }
            catch (Exception ex)
            {
                trans?.Rollback();
                MessageBox.Show("Erro ao aprovar pedido: " + ex.Message, "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            finally
            {
                ClassConexao.Desconectar();
                CarregarPedidos();
            }
        }
        private void btnRejeitar_Click(object sender, EventArgs e)
        {
            if (dataGridView1.SelectedRows.Count > 0)
            {
                int id = Convert.ToInt32(dataGridView1.SelectedRows[0].Cells["id"].Value);

                // Chama o método de apoio para mudar o status para "negado"
                AtualizarStatus(id, "negado");

                // Recarrega a lista de pendentes após a ação
                CarregarPedidos();
            }
            else
            {
                MessageBox.Show("Por favor, selecione um pedido para rejeitar.");
            }
        }
        private void AtualizarStatus(int id, string novoStatus)
        {
            try
            {
                ClassConexao.Conectar();
                string sql = "UPDATE tab_pedidos SET status = @status WHERE id = @id";
                MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn);
                cmd.Parameters.AddWithValue("@status", novoStatus);
                cmd.Parameters.AddWithValue("@id", id);
                cmd.ExecuteNonQuery();

                MessageBox.Show("Pedido atualizado com sucesso!");
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erro ao atualizar: " + ex.Message);
            }
            finally
            {
                ClassConexao.Desconectar();
            }
        }
        private bool ImagemEstaDuplicada(string nomeImagem, int? idObraAtual, MySqlTransaction trans)
        {
            // Monta a consulta base
            string sql = "SELECT COUNT(*) FROM tab_obras WHERE imagem = @imagem";

            // Se estivermos editando uma obra, precisamos excluir ela mesma da verificação
            if (idObraAtual.HasValue)
            {
                sql += " AND id != @id_obra";
            }

            MySqlCommand cmd = new MySqlCommand(sql, ClassConexao.conn, trans);
            cmd.Parameters.AddWithValue("@imagem", nomeImagem);

            if (idObraAtual.HasValue)
            {
                cmd.Parameters.AddWithValue("@id_obra", idObraAtual.Value);
            }

            // ExecuteScalar é usado para obter um único valor (neste caso, a contagem)
            long count = (long)cmd.ExecuteScalar();

            // Se a contagem for maior que 0, a imagem está duplicada
            return count > 0;
        }
    }
}
