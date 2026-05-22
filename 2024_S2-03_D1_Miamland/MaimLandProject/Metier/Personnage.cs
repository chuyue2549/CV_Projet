using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using System.Windows.Input;
using IUTGame;
using MaimLandProject.Metier.Food;


namespace MaimLandProject.Metier
{
    /// <summary>
    /// Personnage qui va être déplacé dans le jeu
    /// </summary>
    public class Personnage : GameItem, IKeyboardInteract, IAnimable
    {
        #region attributs
        // Vitesse de déplacement du personnage
        private double speed = 200; // pixels par seconde

        // Ensemble des touches actuellement enfoncées
        private readonly HashSet<Key> touchesActives = new HashSet<Key>();

        private LifePoint vie;
        private bool isAlive =true;
        private bool isInvincible ;
        private DateTime startInvincible;
        private TimeSpan duringInvincible = TimeSpan.FromSeconds(3);

        private bool isEating ;
        private DateTime startEating;
        private TimeSpan duringEating = TimeSpan.FromSeconds(1);

        private LeJeu jeu;
        #endregion

        #region constrcuteur
        /// <summary>
        /// Constructeur : initialise le sprite de départ et applique une échelle réduite
        /// </summary>
        /// <param name="x"> Coordonnee X </param>
        /// <param name="y"> Coordonnee X </param>
        /// <param name="gmae"> jeu </param>
        public Personnage(double x, double y, Game gmae) : base(x, y, gmae, "front.png")
        {
            vie = new LifePoint(3, 10, 30, gmae);  //initialiser le pont de vie de joueur à 3 au debut
            TheGame.AddItem(vie);

            this.Collidable = true;
        }
        #endregion
        #region propriété
        public LifePoint Vie => vie;
        // Nom symbolique du type de l'objet 
        public override string TypeName => "joueur";

        #endregion
        #region methode

        /// <summary>
        /// Modification le sprite quand le personnage bouge selon le controle de clavier
        /// </summary>
        /// <param name="sprite">le nom sprite qui va être changé</param>
        // Change l’image du sprite et réapplique l’échelle pour éviter qu’il grossisse
        public void ChangeSpriteEtGarderEchelle(string sprite)
        {
            ChangeSprite(sprite);
        }

        

        /// <summary>
        /// Quand une touche est enfoncée, on l’ajoute à la liste des touches actives
        /// </summary>
        /// <param name="key"> touche du clavier </param>
        public void KeyDown(Key key)
        {
            touchesActives.Add(key);
        }

        /// <summary>
        /// Quand la touche est relâchée, on la retire de la liste      
        /// </summary>
        /// <param name="key"> touche du clavier </param>
        public void KeyUp(Key key)
        {
            touchesActives.Remove(key);
        }

        /// <summary>
        /// Retourne la réponse True or False pour savoir que le personnage peut traverser l'item non colliable
        /// </summary>
        /// <param name="dx">la distance de axe x qui va etre ajouté</param>
        /// <param name="dy">la distance de axe y qui va etre ajouté</param>
        /// <returns>Retour le type True or False si le personnage peut passer un item</returns>
        public bool PeutAllerVers(double dx, double dy)
        {
            var objets = ((LeJeu)TheGame).Objets;

            // Simule une nouvelle position temporaire
            double newLeft = Left + dx;
            double newTop = Top + dy;

            // On parcourt tous les objets du jeu
            foreach (var item in objets)
            {
                // On ignore soi-même
                if (item == this || !item.Collidable)
                    continue;

                // Sauvegarder position actuelle
                double oldLeft = Left;
                double oldTop = Top;

                // Position simulée
                Left = newLeft;
                Top = newTop;

                bool collision = IsCollide(item);

                // Revenir à la position originale
                Left = oldLeft;
                Top = oldTop;

                if (collision)
                    return false;
            }

            return true; // pas de collision
        }

        /// <summary>
        /// La méthode qui permet au joueur d'avoir le mouvement, d'animer
        /// </summary>
        /// <param name="dt">le temps pour animer</param>
        // Appelée à chaque frame du jeu : calcule le déplacement selon le temps écoulé
        public void Animate(TimeSpan dt)
        {
            double dx = 0;
            double dy = 0;

            // Bordures du jeu
            double largeurEcran = GameWidth;
            double hauteurEcran = GameHeight;

            // Déplacement selon les touches appuyées
            foreach (var touche in touchesActives)
            {
                if (touche == Key.Left)
                {
                    dx -= speed * dt.TotalSeconds;
                    if (!isEating && !isInvincible)
                        ChangeSpriteEtGarderEchelle("left.png");
                }
                else if (touche == Key.Right)
                {
                    dx += speed * dt.TotalSeconds;
                    if (!isEating && !isInvincible) 
                        ChangeSpriteEtGarderEchelle("right.png");
                }
                else if (touche == Key.Up)
                {
                    dy -= speed * dt.TotalSeconds;
                    if (!isEating && !isInvincible) 
                        ChangeSpriteEtGarderEchelle("front.png");
                }
                else if (touche == Key.Down)
                {
                    dy += speed * dt.TotalSeconds;
                    if (!isEating && !isInvincible) 
                        ChangeSpriteEtGarderEchelle("front.png");
                }
            }

            // Nouvelle position souhaitée
            double nouveauLeft = Left + dx;
            double nouveauTop = Top + dy;

            // Limites horizontales
            if (nouveauLeft < 0)
            {
                dx = -Left; // Ne va pas au-delà du bord gauche
            }
            else if (nouveauLeft + Width > largeurEcran)
            {
                dx = largeurEcran - (Left + Width); // Ne dépasse pas à droite
            }

            // Limites verticales
            if (nouveauTop < 0)
            {
                dy = -Top; // Ne monte pas au-delà du bord supérieur
            }
            else if (nouveauTop + Height > hauteurEcran)
            {
                dy = hauteurEcran - (Top + Height); // Ne descend pas trop
            }

            // Applique le déplacement si possible
            if (PeutAllerVers(dx, dy))
            {
                MoveXY(dx, dy);
            }

            if (isInvincible == true && (DateTime.Now - startInvincible > duringInvincible))
            { 
                isInvincible = false;
                this.ChangeSpriteEtGarderEchelle("front.png");

            }

            if (isEating == true && (DateTime.Now - startEating > duringEating))
            {
                isEating = false;
                this.ChangeSpriteEtGarderEchelle("front.png");

            }
        }



        /// <summary>
        /// quand on touche le montre, le personnage va perdre un point de vie 
        /// </summary>
        /// <param name="other">item que le personnage va toucher</param>
        public override void CollideEffect(GameItem other)

        {
            if (isAlive == true && vie.Vie > 0)
            {
                if (other.TypeName == "Food")
                {
                    //FoodItem eatFood = (FoodItem)other;
                    //eatFood.IsEaten = true;
                    //TheGame.RemoveItem(eatFood);
                    this.isEating = true;
                    this.startEating = DateTime.Now;
                    this.ChangeSpriteEtGarderEchelle("pick.png");
                    

                }

                //si le joueur touche le monstre
                if (other.TypeName == "monstre")
                {

                    if (this.isInvincible ==  false)
                    {
                        vie.PerdreVie();

                        if (vie.Vie == 0)
                        {
                            isAlive = false;
                            TheGame.Loose();
                        }
                        else
                        {
                            this.isInvincible = true;
                            this.startInvincible = DateTime.Now;
                            this.ChangeSpriteEtGarderEchelle("invincible.png");
                        }

                    }

                }
         
            }
        }
        #endregion

    }
}