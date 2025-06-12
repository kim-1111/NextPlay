<?php class User
{
  private $id_usuario;
  private $nombre;
  private $surname;
  private $correo;
  private $contrasena;
  private $estadisticas;
  private $img;
  private $numero;
  private $promotor = false;

  public function __construct(array $data = [])
  {
    if (!empty($data)) {
      if (isset($data['id_usuario']))
        $this->id_usuario = $data['id_usuario'];
      if (isset($data['id_promotor']))
        $this->id_usuario = $data['id_promotor'];
      if (isset($data['nombre']))
        $this->nombre = $data['nombre'];
      if (isset($data['surname']))
        $this->surname = $data['surname'];
      if (isset($data['correo']))
        $this->correo = $data['correo'];
      if (isset($data['email']))
        $this->correo = $data['email'];
      if (isset($data['contrasena']))
        $this->contrasena = $data['contrasena'];
      if (isset($data['estadisticas']))
        $this->estadisticas = $data['estadisticas'];
      if (isset($data['img']))
        $this->img = $data['img'];
      if (isset($data['numero']))
        $this->numero = $data['numero'];
      if (isset($data['promotor']))
        $this->promotor = $data['promotor'];
    }
  }


  /**
   * Get the value of id_usuario
   */
  public function getId_usuario()
  {
    return $this->id_usuario;
  }

  /**
   * Set the value of id_usuario
   *
   * @return  self
   */
  public function setId_usuario($id_usuario)
  {
    $this->id_usuario = $id_usuario;

    return $this;
  }

  /**
   * Get the value of nombre
   */
  public function getNombre()
  {
    return $this->nombre;
  }

  /**
   * Set the value of nombre
   *
   * @return  self
   */
  public function setNombre($nombre)
  {
    $this->nombre = $nombre;

    return $this;
  }

  /**
   * Get the value of surname
   */
  public function getSurname()
  {
    return $this->surname;
  }

  /**
   * Set the value of surname
   *
   * @return  self
   */
  public function setSurname($surname)
  {
    $this->surname = $surname;

    return $this;
  }

  /**
   * Get the value of correo
   */
  public function getCorreo()
  {
    return $this->correo;
  }

  /**
   * Set the value of correo
   *
   * @return  self
   */
  public function setCorreo($correo)
  {
    $this->correo = $correo;

    return $this;
  }

  /**
   * Get the value of contrasena
   */
  public function getContrasena()
  {
    return $this->contrasena;
  }

  /**
   * Set the value of contrasena
   *
   * @return  self
   */
  public function setContrasena($contrasena)
  {
    $this->contrasena = $contrasena;

    return $this;
  }

  /**
   * Get the value of estadisticas
   */
  public function getEstadisticas()
  {
    return $this->estadisticas;
  }

  /**
   * Set the value of estadisticas
   *
   * @return  self
   */
  public function setEstadisticas($estadisticas)
  {
    $this->estadisticas = $estadisticas;

    return $this;
  }

  /**
   * Get the value of img
   */
  public function getImg()
  {
    return $this->img;
  }

  /**
   * Set the value of img
   *
   * @return  self
   */
  public function setImg($img)
  {
    $this->img = $img;

    return $this;
  }

  /**
   * Get the value of promotor
   */ 
  public function getPromotor()
  {
    return $this->promotor;
  }

  /**
   * Set the value of promotor
   *
   * @return  self
   */ 
  public function setPromotor($promotor)
  {
    $this->promotor = $promotor;

    return $this;
  }

  /**
   * Get the value of numero
   */ 
  public function getNumero()
  {
    return $this->numero;
  }

  /**
   * Set the value of numero
   *
   * @return  self
   */ 
  public function setNumero($numero)
  {
    $this->numero = $numero;

    return $this;
  }
}
