import React, { useState } from 'react';

import {StyleSheet, Text, View, Image, TouchableOpacity, TextInput, Alert, ScrollView} from 'react-native';


// ======================================================
// ENDEREÇO DA API
// ======================================================
//
// Android Emulator:
// http://10.0.2.2:3000
//
// Celular físico:
// trocar pelo IP do computador
// http://192.168.1.10:3000
//
// ======================================================

const API_URL = 'http://10.0.2.2:3000';


// Tela inicial da aplicação
export default function App() {

  const [telaAtual, setTelaAtual] = useState('Home');


  // ======================================================
  // CAMPOS DO CADASTRO DE ALUNO
  // ======================================================

  const [nome, setNome] = useState('');
  const [dataNascimento, setDataNascimento] = useState('');
  const [idRuas, setIdRuas] = useState('');
  const [cpf, setCpf] = useState('');
  const [email, setEmail] = useState('');
  const [telefone, setTelefone] = useState('');

  const [carregando, setCarregando] = useState(false);


  // ======================================================
  // CADASTRAR ALUNO
  // ======================================================

  const cadastrarAluno = async () => {

    // Verifica se os campos foram preenchidos
    if (
      !nome ||
      !dataNascimento ||
      !idRuas ||
      !cpf ||
      !email ||
      !telefone
    ) {
      Alert.alert(
        'Atenção',
        'Preencha todos os campos do cadastro.'
      );

      return;
    }


    try {

      setCarregando(true);


      // Envia os dados para a API
      const resposta = await fetch(`${API_URL}/api/alunos`, {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json',
        },

        body: JSON.stringify({
          Nome: nome,
          Data_de_Nascimento: dataNascimento,
          idRuas: Number(idRuas),
          CPF: cpf,
          Email: email,
          Telefone: telefone,
        }),
      });


      const dados = await resposta.json();


      // Se a API retornar erro
      if (!resposta.ok) {

        Alert.alert(
          'Erro',
          dados.erro || 'Não foi possível cadastrar o aluno.'
        );

        return;
      }


      // Cadastro realizado
      Alert.alert(
        'Sucesso',
        'Aluno cadastrado com sucesso!'
      );


      // Limpa os campos
      setNome('');
      setDataNascimento('');
      setIdRuas('');
      setCpf('');
      setEmail('');
      setTelefone('');


    } catch (erro) {

      console.log('Erro ao conectar com a API:', erro);

      Alert.alert(
        'Erro de conexão',
        'Não foi possível conectar com a API. Verifique se o servidor está funcionando.'
      );

    } finally {

      setCarregando(false);

    }
  };


  // ======================================================
  // TELA HOME
  // ======================================================

  if (telaAtual === 'Home') {

    return (
      <View style={styles.container}>

        <Text style={styles.titulo}>
          App Scholar
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Dados Acadêmicos
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Sobre')}
        >
          <Text style={styles.textoBotao}>
            Sobre
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // DADOS ACADÊMICOS
  // ======================================================

  if (telaAtual === 'Dados_Academicos') {

    return (
      <View style={styles.container}>

        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Coordenadores')}
        >
          <Text style={styles.textoBotao}>
            Coordenadores
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Professores')}
        >
          <Text style={styles.textoBotao}>
            Professores
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Responsáveis')}
        >
          <Text style={styles.textoBotao}>
            Responsáveis
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Matrículas')}
        >
          <Text style={styles.textoBotao}>
            Matrículas
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Boletins')}
        >
          <Text style={styles.textoBotao}>
            Boletins
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Turmas')}
        >
          <Text style={styles.textoBotao}>
            Turmas
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Alunos')}
        >
          <Text style={styles.textoBotao}>
            Alunos
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Home')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // SOBRE
  // ======================================================

  if (telaAtual === 'Sobre') {

    return (
      <View style={styles.container}>

        <Text style={styles.titulo}>
          Para que serve o APP Scholar?
        </Text>


        <Text style={styles.caixa}>
          O APP Scholar serve para armazenar informações
          sobre os alunos da escola. Onde podem ser
          inseridas novas informações relacionadas a
          professores, notas, coordenadores e entre outros.
        </Text>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Home')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // COORDENADORES
  // ======================================================

  if (telaAtual === 'Coordenadores') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_coordenador')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar coordenador
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_coordenadores')}
        >
          <Text style={styles.textoBotao}>
            Consultar coordenadores
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // PROFESSORES
  // ======================================================

  if (telaAtual === 'Professores') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_professor')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar professor
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_professores')}
        >
          <Text style={styles.textoBotao}>
            Consultar professores
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // RESPONSÁVEIS
  // ======================================================

  if (telaAtual === 'Responsáveis') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_responsavel')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar responsável
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_responsaveis')}
        >
          <Text style={styles.textoBotao}>
            Consultar responsáveis
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // MATRÍCULAS
  // ======================================================

  if (telaAtual === 'Matrículas') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_matricula')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar matrícula
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_matriculas')}
        >
          <Text style={styles.textoBotao}>
            Consultar matrículas
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // BOLETINS
  // ======================================================

  if (telaAtual === 'Boletins') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_boletins')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar boletins
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_boletins')}
        >
          <Text style={styles.textoBotao}>
            Consultar boletins
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // TURMAS
  // ======================================================

  if (telaAtual === 'Turmas') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_Turmas')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar Turmas
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_Turmas')}
        >
          <Text style={styles.textoBotao}>
            Consultar Turmas
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // ALUNOS
  // ======================================================

  if (telaAtual === 'Alunos') {

    return (
      <View style={styles.container}>

        <Text style={styles.subtitulo2}>
          Selecione o que deseja atualizar:
        </Text>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Cadastrar_Alunos')}
        >
          <Text style={styles.textoBotao}>
            Cadastrar Alunos
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao}
          onPress={() => setTelaAtual('Consultar_Alunos')}
        >
          <Text style={styles.textoBotao}>
            Consultar Alunos
          </Text>
        </TouchableOpacity>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Dados_Academicos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // CADASTRAR ALUNOS
  // ======================================================

  if (telaAtual === 'Cadastrar_Alunos') {

    return (
      <ScrollView
        contentContainerStyle={styles.formularioContainer}
      >

        <Text style={styles.titulo}>
          Cadastrar Aluno
        </Text>


        {/* NOME */}

        <Text style={styles.label}>
          Nome do aluno
        </Text>

        <TextInput
          style={styles.input}
          placeholder="Digite o nome completo"
          value={nome}
          onChangeText={setNome}
        />


        {/* DATA DE NASCIMENTO */}

        <Text style={styles.label}>
          Data de nascimento
        </Text>

        <TextInput
          style={styles.input}
          placeholder="AAAA-MM-DD"
          value={dataNascimento}
          onChangeText={setDataNascimento}
          keyboardType="numbers-and-punctuation"
        />


        {/* ID DA RUA */}

        <Text style={styles.label}>
          ID da rua
        </Text>

        <TextInput
          style={styles.input}
          placeholder="Digite o nome da rua"
          value={idRuas}
          onChangeText={setIdRuas}
          keyboardType="numeric"
        />


        {/* CPF */}

        <Text style={styles.label}>
          CPF
        </Text>

        <TextInput
          style={styles.input}
          placeholder="Digite o CPF"
          value={cpf}
          onChangeText={setCpf}
          keyboardType="numeric"
        />


        {/* EMAIL */}

        <Text style={styles.label}>
          E-mail
        </Text>

        <TextInput
          style={styles.input}
          placeholder="Digite o e-mail"
          value={email}
          onChangeText={setEmail}
          keyboardType="email-address"
          autoCapitalize="none"
        />


        {/* TELEFONE */}

        <Text style={styles.label}>
          Telefone
        </Text>

        <TextInput
          style={styles.input}
          placeholder="Digite o telefone"
          value={telefone}
          onChangeText={setTelefone}
          keyboardType="phone-pad"
        />


        {/* BOTÃO CADASTRAR */}

        <TouchableOpacity
          style={styles.botao}
          onPress={cadastrarAluno}
          disabled={carregando}
        >

          <Text style={styles.textoBotao}>

            {carregando
              ? 'Cadastrando...'
              : 'Cadastrar Aluno'
            }

          </Text>

        </TouchableOpacity>


        {/* BOTÃO VOLTAR */}

        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Alunos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </ScrollView>
    );
  }


  // ======================================================
  // CONSULTAR ALUNOS
  // ======================================================
  if (telaAtual === 'Consultar_Alunos') {

    return (
      <View style={styles.container}>

        <Text style={styles.titulo}>
          Consultar Alunos
        </Text>

        <Text style={styles.caixa}>
          A consulta de alunos ainda será conectada a API.
        </Text>


        <TouchableOpacity
          style={styles.botao2}
          onPress={() => setTelaAtual('Alunos')}
        >
          <Text style={styles.textoBotao}>
            Voltar
          </Text>
        </TouchableOpacity>

      </View>
    );
  }


  // ======================================================
  // ESTILIZAÇÃO
  // ======================================================

  return null;
}


// ======================================================
// ESTILOS
// ======================================================

const styles = StyleSheet.create({

  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#ecf0f1',
    padding: 20,
  },


  formularioContainer: {
    flexGrow: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#ecf0f1',
    padding: 20,
    paddingTop: 40,
    paddingBottom: 40,
  },


  caixa: {
    width: '80%',
    backgroundColor: '#d3d3d3',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    alignItems: 'center',
    textAlign: 'center',
  },


  logo: {
    width: 150,
    height: 150,
    marginBottom: 20,
  },


  titulo: {
    fontSize: 32,
    fontWeight: 'bold',
    textAlign: 'center',
    color: '#FACE07',
    marginBottom: 20,
  },


  subtitulo: {
    fontSize: 18,
    marginBottom: 40,
    color: '#666',
  },


  subtitulo2: {
    fontSize: 18,
    marginBottom: 40,
    fontWeight: 'bold',
    textAlign: 'center',
    color: '#F4C90B',
  },


  label: {
    width: '90%',
    fontSize: 16,
    fontWeight: 'bold',
    color: '#463901',
    marginBottom: 5,
    marginTop: 8,
  },


  input: {
    width: '90%',
    height: 50,
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 10,
    paddingHorizontal: 15,
    fontSize: 16,
    marginBottom: 10,
  },


  botao: {
    width: '80%',
    backgroundColor: '#FACE07',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    alignItems: 'center',
  },


  botao2: {
    width: '80%',
    borderWidth: 2,
    borderColor: '#FACE07',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    alignItems: 'center',
  },


  header: {
    backgroundColor: '#FACE07',
    padding: 10,
    width: '80%',
  },


  textoBotao: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#463901',
  },

});
