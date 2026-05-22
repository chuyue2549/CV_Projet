using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using IUTGame;
using MaimLandProject.Metier.Food;

namespace MaimLandProject.Metier
{
    public class Monstre : GameItem, IAnimable
    {
        #region attributs
        private Game game;
        private double speed = 400; // Vitesse en pixels/seconde
        public int direction = 1;  // 1 = droite, -1 = gauche

        private bool isCollide = false;
        private DateTime startCollide;
        private TimeSpan duringCollide = TimeSpan.FromSeconds(0.5);
        #endregion

        #region propriétés
        public override string TypeName => "monstre";
        public int Direction
        {
            get { return direction; }
            set { direction = value; }
        }
        #endregion

        #region constructeur
        /// <summary>
        /// initial le monstre 
        /// </summary>
        /// <param name="x"> Coordonne X </param>
        /// <param name="y"> Coordonee Y </param>
        /// <param name="game"> jeu </param>
        public Monstre(double x, double y, Game game)
            : base(x, y, game, "M_left.png") // sprite à adapter selon ton fichier
        {
            this.game = game;
            this.Collidable = true;

        }

        #endregion

        #region methodes
        /// <summary>
        /// Vérifie si le monstre peut se déplacer sans collision.
        /// </summary>
        /// <param name="dx"> déplacement dans X </param>
        /// <param name="dy"> déplacement dans Y </param>
        /// <returns></returns>
        public bool PeutAllerVers(double dx, double dy)
        {
            // On récupère tous les objets du jeu ajoutés dans la classe LeJeu
            var objets = ((LeJeu)TheGame).Objets;

            // On calcule la future position du personnage/monstre
            double newLeft = Left + dx;
            double newTop = Top + dy;


            // On vérifie la collision avec chaque objet du jeu
            foreach (var item in objets)
            {
                if (item == this || !item.Collidable || item.TypeName == "joueur")
                    continue;

                // Sauvegarde de la position actuelle
                double oldLeft = Left;
                double oldTop = Top;

                // On simule la nouvelle position
                Left = newLeft;
                Top = newTop;

                // Vérifie s’il y a collision avec l’objet courant
                bool collision = IsCollide(item);

                // On revient à la position d’origine (très important)
                Left = oldLeft;
                Top = oldTop;

                // Si collision détectée, on bloque le déplacement
                if (collision)
                    return false;
            }

            //  on peut se déplacer
            return true;
        }

        /// <summary>
        ///  Mouvement automatique de gauche à droite
        /// </summary>
        /// <param name="dt"> delta time </param>
        public void Animate(TimeSpan dt)
        {
            double dx = speed * dt.TotalSeconds * direction;

            // Si on atteint un bord de l’écran, on inverse la direction
            if (Left + dx < 0 || Right + dx > GameWidth)
            {
                direction *= -1;

                // On change de sprite selon la direction
                if (direction == 1)
                    ChangeSprite("M_right.png");
                else
                    ChangeSprite("M_left.png");
            }

            if (PeutAllerVers(dx, 0))
                MoveXY(dx, 0);
            else
            {
                direction *= -1; // fait demi-tour si bloqué

                // Changement d’image selon la nouvelle direction
                if (direction < 0)
                    ChangeSprite("M_left.png");
                else
                    ChangeSprite("M_right.png");
            }

            if (isCollide == true && (DateTime.Now - startCollide > duringCollide))
            {
                isCollide = false;

            }

        }

        /// <summary>
        /// inverse la direction et change le sprite
        /// </summary>
        public void ChangeDirection() 
        {
            direction *= -1;
            if (direction == 1)
                ChangeSprite("M_right.png");
            else
                ChangeSprite("M_left.png");
        }


        /// <summary>
        /// Gère la collision avec le joueur en changeant de direction avec un temps délai.
        /// </summary>
        /// <param name="other"> l'autre objet en collision </param>
        public override void CollideEffect(GameItem other)
        {
            // déclencher une défaite si le joueur touche le monstre
            if (other.TypeName == "joueur")
            {
                if (isCollide == false) 
                {
                        this.ChangeDirection();
                        this.isCollide = true;
                        this.startCollide = DateTime.Now;

                }
            }
        }
        #endregion
    }
}
